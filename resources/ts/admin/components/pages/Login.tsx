import React, { useState } from "react";

import { useForm } from "react-hook-form";

import Loading from '../parts/Loading';
import { useLogin } from "../queries/AuthQuery";


interface Props {
  title: string
}

interface LoginData {
  email: string,
  password: string,
}

const Login: React.FC<Props> = (props) => {
  const { register, handleSubmit, setError, clearErrors, formState: { errors } } = useForm();
  const [loadingDispFlag, setLoadingDispFlag] = useState<Boolean>(false);

  const login = useLogin();

  const handleLogin = (data: LoginData) => {
    login.mutate(data);
  }
  
  return (
    <>
      <h1　className="font-bold text-left text-2xl">{props.title}</h1>

      <div className="w-full max-w-xs mt-3">
        <form className="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" onSubmit={e => {clearErrors(); handleSubmit(handleLogin)(e)}}>
          <div className="mb-4">
            <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="email">
              email
            </label>
            <input className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="email"
              {...register('email', {
                required: '入力してください'
              })} 
            />
            {errors.email && <span className="block text-red-400">{errors.email.message}</span>}
          </div>
          <div className="mb-6">
            <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="password">
              パスワード
            </label>
            <input className="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************"
              {...register('password', {
                required: '入力してください'
              })} 
            />
            {errors.password && <span className="block text-red-400">{errors.password.message}</span>}
          </div>
          <div className="flex items-center justify-between">
            <button className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
              ログイン
            </button>
            {errors.submit && <span className="block text-red-400">{errors.submit.message}</span>}
          </div>
        </form>
      </div>
      
      {loadingDispFlag && <Loading />}
    </>
  )
}

export default Login