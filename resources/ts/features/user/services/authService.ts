import { apiRequest, ApiResponse } from './api';

// ログイン用の型定義
export interface LoginCredentials {
  email: string;
  password: string;
}

export interface AuthUser {
  id: number;
  name: string;
  email: string;
  role: string;
  // 他に必要なユーザー情報
}

export interface AuthResponse {
  user: AuthUser;
  token: string;
}

// ログインサービス
const login = async (credentials: LoginCredentials): Promise<AuthUser> => {
  const response = await apiRequest<ApiResponse<AuthResponse>>('/login', 'POST', credentials);
  
  if (response.success && response.data) {
    // トークンをローカルストレージに保存
    localStorage.setItem('token', response.data.token);
    return response.data.user;
  }
  
  throw new Error(response.message || 'ログインに失敗しました');
};

// ログアウトサービス
const logout = async (): Promise<void> => {
  try {
    await apiRequest('/logout', 'POST');
  } finally {
    // ローカルストレージからトークンを削除
    localStorage.removeItem('token');
  }
};

// 現在のユーザー情報を取得
const getCurrentUser = async (): Promise<AuthUser | null> => {
  try {
    const response = await apiRequest<ApiResponse<AuthUser>>('/user');
    return response.data || null;
  } catch (error) {
    return null;
  }
};

export const authService = {
  login,
  logout,
  getCurrentUser
};
