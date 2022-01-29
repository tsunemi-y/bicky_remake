import { useEffect } from 'react';

import { 
    BrowserRouter, 
    Switch,
    Route,
    RouteProps,
    Redirect  
} from 'react-router-dom';

import { useAuth } from './hooks/AuthContext';
import { useUser }  from './queries/AuthQuery';
import Login from './pages/Login';
import ReservatinTop from './pages/ReservatinTop';
import Receipt from './pages/Receipt';
import ReceiptSend from './pages/ReceiptSend';
import SideMenu from './parts/SideMenu';

const Router = () => {
    const { isAuth, setIsAuth } = useAuth();
    const { isLoading, data: authUser } = useUser();

    useEffect(() => {
        console.log('isAuth: ' + isAuth);
        if (authUser) setIsAuth(true);
    }, [authUser]); // useEffectの第２引数に指定した値が変わった時に再度実行される

    const LoginRoute = (props: RouteProps) => {
        if (isAuth) return <Redirect to="/admin/reservation" />
        return <Route {...props} />
    };

    const GuardRoute = (props: RouteProps) => {
        if (!isAuth) return <Redirect to="/admin/login" />
        return <Route {...props} />
    };

    return (
        <BrowserRouter>
            { isAuth ?? 
                <div　className="bg-blue-900 pt-5 text-white w-52">　
                    <SideMenu/>
                </div>
            }
            <div　className="bg-gray-200 h-screen pt-5 w-11/12">
                <div className="ml-5">
                    <Switch>
                        <LoginRoute path='/admin/login' render={ () => <Login title={'ログイン'}/> }/>
                        <GuardRoute path='/admin/reservation' render={ () => <ReservatinTop title={'予約一覧'}/> }/>
                        <GuardRoute path='/admin/receipt/send/:id' render={ () => <ReceiptSend title={'領収書送信'}/> }/>
                        <GuardRoute path='/admin/receipt' render={ () => <Receipt title={'領収書'}/> }/>
                    </Switch>
                </div>
            </div>
        </BrowserRouter>
    )
}

export default Router