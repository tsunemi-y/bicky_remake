import React, { useState, useEffect } from 'react';
import { reservationService } from '../../services/reservationService';
import './style.css';

// 予約データの型定義
interface Reservation {
  id: number;
  date: string;
  timeSlot: string;
  courseName: string;
  status: string;
}

const CancelReservation = () => {
  // 予約一覧の状態
  const [reservations, setReservations] = useState<Reservation[]>([]);
  // ローディング状態
  const [loading, setLoading] = useState(true);
  // エラー状態
  const [error, setError] = useState<string | null>(null);
  // キャンセル確認モーダルの状態
  const [showModal, setShowModal] = useState(false);
  // キャンセル対象の予約ID
  const [selectedReservationId, setSelectedReservationId] = useState<number | null>(null);

  // 予約一覧を取得する
  useEffect(() => {
    const fetchReservations = async () => {
      try {
        setLoading(true);
        // reservationServiceからユーザーの予約一覧を取得
        const response = await reservationService.getUserReservations();
        setReservations(response);
        setError(null);
      } catch (err) {
        console.error('予約取得エラー:', err);
        setError('予約情報の取得に失敗しました。');
      } finally {
        setLoading(false);
      }
    };

    fetchReservations();
  }, []);

  // キャンセル確認ダイアログを表示
  const handleCancelClick = (reservationId: number) => {
    setSelectedReservationId(reservationId);
    setShowModal(true);
  };

  // キャンセル処理を実行
  const confirmCancel = async () => {
    if (selectedReservationId === null) return;

    try {
      setLoading(true);
      // 予約キャンセルAPIを呼び出し
      await reservationService.cancelReservation(selectedReservationId);
      
      // 予約一覧を更新
      setReservations(reservations.map(reservation => 
        reservation.id === selectedReservationId 
          ? { ...reservation, status: 'cancelled' } 
          : reservation
      ));
      
      setShowModal(false);
      setError(null);
    } catch (err) {
      console.error('キャンセルエラー:', err);
      setError('予約のキャンセルに失敗しました。');
    } finally {
      setLoading(false);
    }
  };

  // キャンセル確認ダイアログを閉じる
  const closeModal = () => {
    setShowModal(false);
    setSelectedReservationId(null);
  };

  // 日付をフォーマットする関数
  const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('ja-JP', {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      weekday: 'long'
    }).format(date);
  };

  return (
    <div className="cancel-reservation-container">
      <h1 className="page-title">予約確認・キャンセル</h1>
      
      {loading && <p className="loading-message">予約情報を取得中...</p>}
      
      {error && <p className="error-message">{error}</p>}
      
      {!loading && !error && (
        <>
          {reservations.length === 0 ? (
            <p className="no-reservations">現在予約はありません。</p>
          ) : (
            <div className="reservations-list">
              {reservations.map(reservation => (
                <div key={reservation.id} className={`reservation-card ${reservation.status === 'cancelled' ? 'cancelled' : ''}`}>
                  <div className="reservation-header">
                    <span className={`status-badge ${reservation.status}`}>
                      {reservation.status === 'confirmed' ? '予約確定' : 
                       reservation.status === 'pending' ? '予約中' : 'キャンセル済み'}
                    </span>
                    <span className="reservation-id">予約番号: {reservation.id}</span>
                  </div>
                  
                  <div className="reservation-details">
                    <p className="reservation-date">
                      <strong>日時:</strong> {formatDate(reservation.date)} {reservation.timeSlot}
                    </p>
                    <p className="reservation-course">
                      <strong>コース:</strong> {reservation.courseName}
                    </p>
                  </div>
                  
                  {(reservation.status === 'confirmed' || reservation.status === 'pending') && (
                    <div className="reservation-actions">
                      <button 
                        className="cancel-button"
                        onClick={() => handleCancelClick(reservation.id)}
                      >
                        この予約をキャンセルする
                      </button>
                    </div>
                  )}
                </div>
              ))}
            </div>
          )}
        </>
      )}
      
      {/* キャンセル確認モーダル */}
      {showModal && (
        <div className="modal-overlay">
          <div className="modal-content">
            <h2>予約キャンセルの確認</h2>
            <p>この予約をキャンセルしてもよろしいですか？</p>
            <p className="warning-text">※キャンセル後の復旧はできません。</p>
            
            <div className="modal-actions">
              <button 
                className="cancel-confirm-button"
                onClick={confirmCancel}
                disabled={loading}
              >
                キャンセルする
              </button>
              <button 
                className="cancel-back-button"
                onClick={closeModal}
                disabled={loading}
              >
                戻る
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};

export default CancelReservation;
