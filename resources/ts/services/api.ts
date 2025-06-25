// API基本設定
const API_BASE_URL = process.env.MIX_API_URL || `${window.location.protocol}//${window.location.host}/api`;

// 共通ヘッダー
const getHeaders = () => {
  const headers: HeadersInit = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'X-CSRF-TOKEN': window.csrfToken || '',
  };

  // ローカルストレージからトークンを取得
  const token = localStorage.getItem('access_token');
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
      credentials: 'include',
      headers: getHeaders(),
      body: data ? JSON.stringify(data) : undefined,
    };

    // モバイルデバイス用のタイムアウト設定
    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), 30000); // 30秒タイムアウト
    
    const response = await fetch(url, {
      ...options,
      signal: controller.signal,
    });
    
    clearTimeout(timeoutId);
    const responseData = await response.json();

    if (!response.ok) {
      throw new Error(responseData.message || '通信エラーが発生しました');
    }

    return responseData as T;
  } catch (error) {
    // AbortErrorの場合はタイムアウトエラーとして扱う
    if (error instanceof Error && error.name === 'AbortError') {
      throw new Error('リクエストがタイムアウトしました。ネットワーク接続を確認してください。');
    }
    // TypeError（ネットワークエラー）の場合
    if (error instanceof TypeError) {
      throw new Error('ネットワークエラーが発生しました。接続を確認してください。');
    }
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
