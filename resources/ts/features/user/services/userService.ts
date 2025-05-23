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

// 親ユーザー情報の型定義
export interface ParentData {
  parentName: string;
  parentNameKana: string;
  email: string;
  tel: string;
  password: string;
  password_confirmation: string;
  childName: string;
  childNameKana: string;
  age: number | string;
  gender: string;
  diagnosis?: string;
  childName2?: string;
  childNameKana2?: string;
  age2?: number | string;
  gender2?: string;
  diagnosis2?: string;
  postCode: string;
  address: string;
  lineConsultation?: boolean;
  introduction?: string;
  consultation?: string;
}

export interface RegisterResponse {
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

// 新規登録サービス
const register = async (userData: ParentData): Promise<AuthUser> => {
  const response = await apiRequest<ApiResponse<RegisterResponse>>('/register', 'POST', userData);
  
  if (response.success && response.data) {
    // トークンをローカルストレージに保存
    localStorage.setItem('token', response.data.token);
    return response.data.user;
  }
  
  throw new Error(response.message || '新規登録に失敗しました');
};

// ユーザー情報更新サービス
const update = async (userId: number, userData: Partial<ParentData>): Promise<AuthUser> => {
  const response = await apiRequest<ApiResponse<AuthUser>>(`/users/${userId}`, 'PUT', userData);
  
  if (response.success && response.data) {
    return response.data;
  }
  
  throw new Error(response.message || 'ユーザー情報の更新に失敗しました');
};

export const userService = {
  login,
  logout,
  getCurrentUser,
  register,
  update
};
