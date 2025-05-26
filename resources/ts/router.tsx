// router.tsx
import { createBrowserRouter } from 'react-router-dom';

// ユーザー
import UserLayout from './features/user/components/UserLayout';
import UserHome from './features/user/pages/Home';
import UserReservation from './features/user/pages/Reservation';
import UserRegister from './features/user/pages/Register';
import UserLogin from './features/user/pages/Login';
import UserFee from './features/user/pages/Fee';
import UserAccess from './features/user/pages/Access';
import UserIntroduction from './features/user/pages/Introduction';
import UserGreeting from './features/user/pages/Greeting';

// // 管理者
// import AdminLayout from './features/admin/components/AdminLayout';
// import AdminDashboard from './features/admin/pages/Dashboard';
// import UserManagement from './features/admin/pages/UserManagement';

export const router = createBrowserRouter([
  // 一般ユーザー画面ルート
  {
    path: '/',
    element: <UserLayout />,
    children: [
      { index: true, element: <UserHome /> },
      { path: 'reservation', element: <UserReservation /> },
      { path: 'register', element: <UserRegister /> },
      { path: 'login', element: <UserLogin /> },
      { path: 'fee', element: <UserFee /> },
      { path: 'access', element: <UserAccess /> },
      { path: 'introduction', element: <UserIntroduction /> },
      { path: 'greeting', element: <UserGreeting /> },
      // 他のユーザーページ
    ]
  },
  // 管理画面ルート
  // {
  //   path: '/admin',
  //   element: <AdminLayout />,
  //   children: [
  //     { index: true, element: <AdminDashboard /> },
  //     { path: 'users', element: <UserManagement /> },
  //     // 他の管理ページ
  //   ]
  // }
]);

export default router;