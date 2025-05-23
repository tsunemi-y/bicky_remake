import React, { useState } from 'react';
import './style.css';

const Register = () => {
  // フォームの状態
  const [formValues, setFormValues] = useState({
    parentName: '',
    parentNameKana: '',
    email: '',
    tel: '',
    password: '',
    passwordConfirmation: '',
    childName: '',
    childNameKana: '',
    age: '',
    gender: '男の子',
    diagnosis: '',
    postCode: '',
    address: '',
    lineConsultation: false,
    introduction: '',
    consultation: ''
  });

  // エラー状態
  const [errors, setErrors] = useState<Record<string, string>>({});
  const [showPassword, setShowPassword] = useState(false);
  const [showPasswordConfirm, setShowPasswordConfirm] = useState(false);

  // フォームの入力変更ハンドラ
  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    const { name, value, type } = e.target as HTMLInputElement;
    setFormValues({
      ...formValues,
      [name]: type === 'checkbox' ? (e.target as HTMLInputElement).checked : value
    });
  };

  // フォーム送信ハンドラ
  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    // バリデーション
    const newErrors: Record<string, string> = {};
    
    // 必須項目チェック
    if (!formValues.parentName) newErrors.parentName = '保護者氏名は必須';

    // エラー状態の更新
    setErrors(newErrors);
  };

  return (
    <div>
      {/* フォームのHTML部分 */}
    </div>
  );
};

export default Register;
