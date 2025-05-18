import { apiRequest, ApiResponse } from './api';

// 予約関連の型定義
export type AvailableReservation = {
  available_date: string;
  available_times: string[];
}

export type Reservation = {
  date: string;
  time: string;
  children: number[];
  course: number;
};

// 予約一覧を取得
const getAvailableReservations = async (): Promise<AvailableReservation[]> => {
  const response = await apiRequest<ApiResponse<AvailableReservation[]>>('/reservations');
  
  if (response.success && response.data) {
    return response.data;
  }
  
  throw new Error(response.message || '予約情報の取得に失敗しました');
};

// 予約作成
const createReservation = async (data: Reservation): Promise<Reservation> => {
  const response = await apiRequest<ApiResponse<Reservation>>('/reservations', 'POST', data);
  
  if (response.success && response.data) {
    return response.data;
  }
  
  throw new Error(response.message || '予約の作成に失敗しました');
};

// コース一覧を取得
const getCourse = async (): Promise<any[]> => {
  const response = await apiRequest<ApiResponse<any[]>>('/courses');
  
  if (response.success && response.data) {
    return response.data;
  }
  
  throw new Error(response.message || 'コース情報の取得に失敗しました');
};

export const reservationService = {
  getAvailableReservations,
  createReservation,
  getCourse,
};
