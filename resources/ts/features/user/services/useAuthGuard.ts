import { useMemo } from 'react';

const useAuthGuard = (): boolean => {
  return useMemo(() => {
    const token = localStorage.getItem('access_token');
    if (!token) {
      return false;
    }
    try {
      const payload = JSON.parse(atob(token.split('.')[1]));
      const now = Math.floor(Date.now() / 1000);
      if (payload.exp && payload.exp < now) {
        return false;
      }
      return true;
    } catch (e) {
      return false;
    }
  }, []);
};

export default useAuthGuard;