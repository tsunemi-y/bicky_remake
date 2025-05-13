// API基本設定
const API_BASE_URL = process.env.REACT_APP_API_URL || 'http://localhost:8000/api';

// 共通ヘッダー
const getHeaders = () => {
  const headers: HeadersInit = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  };

  // ローカルストレージからトークンを取得
  const token = localStorage.getItem('token');
  if (token) {
    headers['Authorization'] = `Bearer ${token}`;
  }

  return headers;
};

// APIリクエスト処理の基本関数
export const apiRequest = async <T>(
  endpoint: string, 
  method: string = 'GET', 
  data?: any
): Promise<T> => {
  try {
    const url = `${API_BASE_URL}${endpoint}`;
    const options: RequestInit = {
      method,
      headers: getHeaders(),
      body: data ? JSON.stringify(data) : undefined,
    };

    const response = await fetch(url, options);
    const responseData = await response.json();

    if (!response.ok) {
      throw new Error(responseData.message || '通信エラーが発生しました');
    }

    return responseData as T;
  } catch (error) {
    if (error instanceof Error) {
      throw new Error(error.message);
    }
    throw new Error('予期せぬエラーが発生しました');
  }
};

// レスポンス型定義
export interface ApiResponse<T> {
  success: boolean;
  data?: T;
  message?: string;
  errors?: Record<string, string[]>;
}
