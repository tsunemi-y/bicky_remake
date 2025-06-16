import { apiRequest, ApiResponse } from './api';

// 予約関連の型定義
// サーバーから返るデータ構造に合わせて修正
// 例: { avaTimes: { "2023-01-14": ["10:00:00", ...], ... } }
export type AvailableReservation = {
  avaDates: string[];
  avaTimes: {
    [date: string]: string[];
  };
};

export type Reservation = {
  date: string;
  time: string;
  children: number[];
  course: number;
};

export type UserReservation = {
  id: number;
  date: string;
  time: string;
};

export type ReservationResponse = {
  message: string;
};

// export type UserReservationResponse = {
//   id: number;
//   user_id: number;
//   reservation_date: string;
//   reservation_time: string;
//   use_time: number;
//   created_at: string;
//   updated_at: string;
// };

export type UserReservationResponse = any;

// 予約一覧を取得
const getAvailableReservations = async (): Promise<AvailableReservation> => {
  const response = await apiRequest<ApiResponse<AvailableReservation>>('/reservations');
  
  if (response.success && response.data) {
    return response.data;
  }
  
  throw new Error(response.message || '予約情報の取得に失敗しました');
};

// 予約作成
const createReservation = async (data: Reservation): Promise<ReservationResponse> => {
  try {
    const response = await apiRequest<ApiResponse<ReservationResponse>>('/reservations', 'POST', data);

    if (response.success && response.data) {
      return response.data;
    }

    throw new Error(response.message || '予約の作成に失敗しました');
  } catch (error: any) {
    throw new Error(error?.message || '予約の作成に失敗しました');
  }
};

// コース一覧を取得
const getCourse = async (): Promise<any[]> => {
  try {
    const response = await apiRequest<ApiResponse<any[]>>('/courses');
    
    if (response.success && response.data) {
      return response.data;
    }
    
    throw new Error(response.message || 'コース情報の取得に失敗しました');
  } catch (error: any) {
    throw new Error(error?.message || 'コース情報の取得に失敗しました');
  }
};

const getUserReservations = async (): Promise<UserReservation[]> => {
  const response = await apiRequest<ApiResponse<UserReservation[]>>('/reservations/user');

  if (response.success && response.data) {
    return response.data;
  }

  throw new Error(response.message || '予約情報の取得に失敗しました');
};

const cancelReservation = async (reservationId: number): Promise<UserReservationResponse> => {
  const response = await apiRequest<ApiResponse<UserReservationResponse>>(`/reservations/${reservationId}`, 'DELETE');

  if (response.success && response.data) {
    return response.data;
  }

  throw new Error(response.message || '予約のキャンセルに失敗しました');
};

export const reservationService = {
  getAvailableReservations,
  createReservation,
  getCourse,
  getUserReservations,
  cancelReservation,
};
