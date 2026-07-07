import { render, useState, useEffect, useCallback } from '@wordpress/element';
import {
  Card,
  CardHeader,
  CardBody,
  Button,
  SelectControl,
  Modal,
  Notice,
  Spinner,
  Flex,
  FlexBlock,
  FlexItem,
  TextHighlight,
  SearchControl,
  __experimentalHeading as Heading,
  __experimentalText as Text,
  Icon,
  TabPanel,
} from '@wordpress/components';
import { useState as wpState, useDispatch } from '@wordpress/data';
import { __, _n, sprintf } from '@wordpress/i18n';
import { moreHorizontal, trash, check, update, calendar, edit } from '@wordpress/icons';
import apiFetch from '@wordpress/api-fetch';

const STATUS_MAP = {
  pending: { label: __('در انتظار', 'rozholy-companion'), color: '#f59e0b' },
  confirmed: { label: __('تایید شده', 'rozholy-companion'), color: '#10b981' },
  completed: { label: __('انجام شده', 'rozholy-companion'), color: '#6366f1' },
  cancelled: { label: __('لغو شده', 'rozholy-companion'), color: '#ef4444' },
};

function StatusBadge({ status }) {
  const s = STATUS_MAP[status] || STATUS_MAP.pending;
  return (
    <span
      style={{
        display: 'inline-block',
        padding: '2px 10px',
        borderRadius: 999,
        fontSize: 12,
        fontWeight: 600,
        background: s.color,
        color: '#fff',
      }}
    >
      {s.label}
    </span>
  );
}

function BookingRow({ booking, onStatusUpdate, onDelete, onView }) {
  const [showActions, setShowActions] = useState(false);

  return (
    <div
      style={{
        display: 'grid',
        gridTemplateColumns: '2fr 1.5fr 1.5fr 1.5fr 1fr 80px',
        gap: 12,
        alignItems: 'center',
        padding: '12px 16px',
        borderBottom: '1px solid #f0f0f1',
        fontSize: 14,
      }}
    >
      <div style={{ fontWeight: 500, color: '#1e1e1e' }}>{booking.name}</div>
      <div style={{ color: '#50575e' }}>{booking.phone}</div>
      <div style={{ color: '#50575e' }}>{booking.service}</div>
      <div style={{ color: '#50575e' }}>{booking.bookingDate}</div>
      <div><StatusBadge status={booking.status} /></div>
      <div style={{ position: 'relative' }}>
        <Button
          icon={moreHorizontal}
          onClick={() => setShowActions(!showActions)}
          label={__('عملیات', 'rozholy-companion')}
          style={{ minWidth: 36 }}
        />
        {showActions && (
          <div
            style={{
              position: 'absolute',
              right: 0,
              top: '100%',
              background: '#fff',
              border: '1px solid #e2e4e7',
              borderRadius: 4,
              boxShadow: '0 2px 8px rgba(0,0,0,0.08)',
              zIndex: 10,
              minWidth: 150,
            }}
          >
            <Button
              onClick={() => { onView(booking); setShowActions(false); }}
              style={{ width: '100%', justifyContent: 'flex-start', padding: '8px 12px' }}
            >
              {__('جزئیات', 'rozholy-companion')}
            </Button>
            {booking.status !== 'confirmed' && (
              <Button
                onClick={() => { onStatusUpdate(booking.id, 'confirmed'); setShowActions(false); }}
                style={{ width: '100%', justifyContent: 'flex-start', padding: '8px 12px' }}
              >
                ✅ {__('تایید', 'rozholy-companion')}
              </Button>
            )}
            {booking.status !== 'completed' && (
              <Button
                onClick={() => { onStatusUpdate(booking.id, 'completed'); setShowActions(false); }}
                style={{ width: '100%', justifyContent: 'flex-start', padding: '8px 12px' }}
              >
                ✅ {__('انجام شده', 'rozholy-companion')}
              </Button>
            )}
            {booking.status !== 'cancelled' && (
              <Button
                onClick={() => { onStatusUpdate(booking.id, 'cancelled'); setShowActions(false); }}
                style={{ width: '100%', justifyContent: 'flex-start', padding: '8px 12px' }}
              >
                ❌ {__('لغو', 'rozholy-companion')}
              </Button>
            )}
            <Button
              onClick={() => { onDelete(booking.id); setShowActions(false); }}
              style={{ width: '100%', justifyContent: 'flex-start', padding: '8px 12px', color: '#cc1818' }}
            >
              🗑️ {__('حذف', 'rozholy-companion')}
            </Button>
          </div>
        )}
      </div>
    </div>
  );
}

function BookingDetail({ booking, onClose }) {
  return (
    <Modal
      title={sprintf(__('جزئیات رزرو: %s', 'rozholy-companion'), booking.name)}
      onRequestClose={onClose}
    >
      <div style={{ display: 'flex', flexDirection: 'column', gap: 16 }}>
        <div>
          <strong>{__('نام:', 'rozholy-companion')}</strong> {booking.name}
        </div>
        <div>
          <strong>{__('شماره تماس:', 'rozholy-companion')}</strong> {booking.phone}
        </div>
        <div>
          <strong>{__('خدمت:', 'rozholy-companion')}</strong> {booking.service || '-'}
        </div>
        <div>
          <strong>{__('تاریخ رزرو:', 'rozholy-companion')}</strong> {booking.bookingDate || '-'}
        </div>
        <div>
          <strong>{__('وضعیت:', 'rozholy-companion')}</strong>{' '}
          <StatusBadge status={booking.status} />
        </div>
        {booking.message && (
          <div>
            <strong>{__('پیام:', 'rozholy-companion')}</strong>
            <p style={{ background: '#f6f7f7', padding: 12, borderRadius: 4, marginTop: 4 }}>
              {booking.message}
            </p>
          </div>
        )}
        <div>
          <strong>{__('تاریخ ثبت:', 'rozholy-companion')}</strong>{' '}
          {new Date(booking.createdAt).toLocaleDateString('fa-IR')}
        </div>
      </div>
    </Modal>
  );
}

function BookingManager() {
  const [bookings, setBookings] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [notice, setNotice] = useState(null);
  const [selectedBooking, setSelectedBooking] = useState(null);
  const [statusFilter, setStatusFilter] = useState('all');
  const [searchTerm, setSearchTerm] = useState('');

  const loadBookings = useCallback(async (status = 'all') => {
    setLoading(true);
    setError(null);
    try {
      const params = { per_page: 100 };
      if (status !== 'all') params.status = status;
      const data = await apiFetch({ path: `/rozholy-companion/v1/bookings?${new URLSearchParams(params)}` });
      setBookings(data.items || []);
    } catch {
      setError(__('خطا در بارگذاری رزروها', 'rozholy-companion'));
    } finally {
      setLoading(false);
    }
  }, []);

  useEffect(() => { loadBookings(statusFilter); }, [statusFilter, loadBookings]);

  const handleStatusUpdate = async (id, newStatus) => {
    try {
      await apiFetch({
        path: `/rozholy-companion/v1/bookings/${id}/status`,
        method: 'PUT',
        data: { status: newStatus },
      });
      setNotice({ type: 'success', message: __('وضعیت به‌روزرسانی شد', 'rozholy-companion') });
      loadBookings(statusFilter);
    } catch {
      setNotice({ type: 'error', message: __('خطا در به‌روزرسانی', 'rozholy-companion') });
    }
  };

  const handleDelete = async (id) => {
    if (!confirm(__('آیا از حذف این رزرو اطمینان دارید؟', 'rozholy-companion'))) return;
    try {
      await apiFetch({ path: `/rozholy-companion/v1/bookings/${id}`, method: 'DELETE' });
      setNotice({ type: 'success', message: __('رزرو حذف شد', 'rozholy-companion') });
      loadBookings(statusFilter);
    } catch {
      setNotice({ type: 'error', message: __('خطا در حذف', 'rozholy-companion') });
    }
  };

  const filteredBookings = bookings.filter((b) =>
    !searchTerm || b.name.includes(searchTerm) || b.phone.includes(searchTerm)
  );

  const tabs = [
    { name: 'all', title: __('همه', 'rozholy-companion') },
    { name: 'pending', title: __('در انتظار', 'rozholy-companion') },
    { name: 'confirmed', title: __('تایید شده', 'rozholy-companion') },
    { name: 'completed', title: __('انجام شده', 'rozholy-companion') },
    { name: 'cancelled', title: __('لغو شده', 'rozholy-companion') },
  ];

  return (
    <div style={{ maxWidth: 1200, margin: '0 auto' }}>
      <Card>
        <CardHeader style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', flexWrap: 'wrap', gap: 12 }}>
          <Heading level={3} style={{ margin: 0 }}>
            {__('مدیریت رزروها', 'rozholy-companion')}
          </Heading>
          <div style={{ display: 'flex', gap: 8 }}>
            <SearchControl
              value={searchTerm}
              onChange={setSearchTerm}
              placeholder={__('جستجو...', 'rozholy-companion')}
              style={{ minWidth: 200 }}
            />
            <Button
              variant="secondary"
              icon={update}
              onClick={() => loadBookings(statusFilter)}
              label={__('بروزرسانی', 'rozholy-companion')}
            />
          </div>
        </CardHeader>

        <CardBody style={{ padding: 0 }}>
          <TabPanel
            tabs={tabs}
            onSelect={(tab) => setStatusFilter(tab.name)}
            initialTabName={statusFilter}
            style={{ padding: '0 16px' }}
          >
            {(tab) => null}
          </TabPanel>

          {notice && (
            <div style={{ padding: '8px 16px' }}>
              <Notice
                status={notice.type}
                onRemove={() => setNotice(null)}
                isDismissible
              >
                {notice.message}
              </Notice>
            </div>
          )}

          <div
            style={{
              display: 'grid',
              gridTemplateColumns: '2fr 1.5fr 1.5fr 1.5fr 1fr 80px',
              gap: 12,
              padding: '10px 16px',
              background: '#f6f7f7',
              borderBottom: '1px solid #e2e4e7',
              fontSize: 12,
              fontWeight: 600,
              color: '#50575e',
              textTransform: 'uppercase',
            }}
          >
            <div>{__('نام', 'rozholy-companion')}</div>
            <div>{__('شماره تماس', 'rozholy-companion')}</div>
            <div>{__('خدمت', 'rozholy-companion')}</div>
            <div>{__('تاریخ', 'rozholy-companion')}</div>
            <div>{__('وضعیت', 'rozholy-companion')}</div>
            <div>{__('عملیات', 'rozholy-companion')}</div>
          </div>

          {loading ? (
            <div style={{ textAlign: 'center', padding: 40 }}>
              <Spinner />
              <p>{__('در حال بارگذاری...', 'rozholy-companion')}</p>
            </div>
          ) : error ? (
            <div style={{ textAlign: 'center', padding: 40, color: '#cc1818' }}>
              <p>{error}</p>
              <Button variant="secondary" onClick={() => loadBookings(statusFilter)}>
                {__('تلاش مجدد', 'rozholy-companion')}
              </Button>
            </div>
          ) : filteredBookings.length === 0 ? (
            <div style={{ textAlign: 'center', padding: 40, color: '#757575' }}>
              <p>{__('هیچ رزروی یافت نشد', 'rozholy-companion')}</p>
            </div>
          ) : (
            filteredBookings.map((booking) => (
              <BookingRow
                key={booking.id}
                booking={booking}
                onStatusUpdate={handleStatusUpdate}
                onDelete={handleDelete}
                onView={setSelectedBooking}
              />
            ))
          )}

          <div style={{ padding: '12px 16px', borderTop: '1px solid #e2e4e7', fontSize: 13, color: '#757575' }}>
            {sprintf(__('نمایش %d از %d رزرو', 'rozholy-companion'), filteredBookings.length, bookings.length)}
          </div>
        </CardBody>
      </Card>

      {selectedBooking && (
        <BookingDetail
          booking={selectedBooking}
          onClose={() => setSelectedBooking(null)}
        />
      )}
    </div>
  );
}

document.addEventListener('DOMContentLoaded', () => {
  const root = document.getElementById('rz-booking-root');
  if (root) {
    render(<BookingManager />, root);
  }
});
