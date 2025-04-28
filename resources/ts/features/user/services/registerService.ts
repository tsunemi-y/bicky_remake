import { apiRequest, ApiResponse } from './api';
import { AuthUser } from './loginService';

// 新規登録用の型定義
export interface RegisterData {
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

// 新規登録サービス
const register = async (userData: RegisterData): Promise<AuthUser> => {
  const response = await apiRequest<ApiResponse<RegisterResponse>>('/register', 'POST', userData);
  
  if (response.success && response.data) {
    // トークンをローカルストレージに保存
    localStorage.setItem('token', response.data.token);
    return response.data.user;
  }
  
  throw new Error(response.message || '新規登録に失敗しました');
};

export const registerService = {
  register
};
