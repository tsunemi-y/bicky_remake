// router.tsx
import { createBrowserRouter } from 'react-router-dom';

// ユーザー
import UserLayout from './features/user/components/UserLayout';
import UserHome from './features/user/pages/Home';
import UserFee from './features/user/pages/Fee';

// 管理者
import AdminLayout from './features/admin/components/AdminLayout';
import AdminDashboard from './features/admin/pages/Dashboard';
import UserManagement from './features/admin/pages/UserManagement';

export const router = createBrowserRouter([
  // 一般ユーザー画面ルート
  {
    path: '/',
    element: <UserLayout />,
    children: [
      { index: true, element: <UserHome /> },
      { path: 'fee', element: <UserFee /> },
      // 他のユーザーページ
    ]
  },
  // 管理画面ルート
  {
    path: '/admin',
    element: <AdminLayout />,
    children: [
      { index: true, element: <AdminDashboard /> },
      { path: 'users', element: <UserManagement /> },
      // 他の管理ページ
    ]
  }
]);