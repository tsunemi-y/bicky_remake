import { apiRequest, ApiResponse } from '../../services/api';

// 予約関連の型定義
export interface Reservation {
  id: number;
  userId: number;
  childId: number;
  courseId: number;
  date: string;
  timeSlot: string;
  status: 'pending' | 'confirmed' | 'cancelled';
  createdAt: string;
  updatedAt: string;
}

export interface ReservationCreateData {
  childId: number;
  courseId: number;
  date: string;
  timeSlot: string;
  notes?: string;
}

// 空き状況確認用の型
export interface TimeSlot {
  id: number;
  time: string;
  available: boolean;
}

export interface AvailabilityData {
  date: string;
  courseId: number;
}

// 予約一覧を取得
const getReservations = async (): Promise<Reservation[]> => {
  const response = await apiRequest<ApiResponse<Reservation[]>>('/reservations');
  
  if (response.success && response.data) {
    return response.data;
  }
  
  throw new Error(response.message || '予約情報の取得に失敗しました');
};

// 特定の予約詳細を取得
const getReservation = async (id: number): Promise<Reservation> => {
  const response = await apiRequest<ApiResponse<Reservation>>(`/reservations/${id}`);
  
  if (response.success && response.data) {
    return response.data;
  }
  
  throw new Error(response.message || '予約情報の取得に失敗しました');
};

// 予約作成
const createReservation = async (data: ReservationCreateData): Promise<Reservation> => {
  const response = await apiRequest<ApiResponse<Reservation>>('/reservations', 'POST', data);
  
  if (response.success && response.data) {
    return response.data;
  }
  
  throw new Error(response.message || '予約の作成に失敗しました');
};

// 予約キャンセル
const cancelReservation = async (id: number): Promise<Reservation> => {
  const response = await apiRequest<ApiResponse<Reservation>>(`/reservations/${id}/cancel`, 'PUT');
  
  if (response.success && response.data) {
    return response.data;
  }
  
  throw new Error(response.message || '予約のキャンセルに失敗しました');
};

// 特定日の空き状況を確認
const checkAvailability = async (data: AvailabilityData): Promise<TimeSlot[]> => {
  const response = await apiRequest<ApiResponse<TimeSlot[]>>('/availability', 'POST', data);
  
  if (response.success && response.data) {
    return response.data;
  }
  
  throw new Error(response.message || '空き状況の取得に失敗しました');
};

export const reservationService = {
  getReservations,
  getReservation,
  createReservation,
  cancelReservation,
  checkAvailability
};
