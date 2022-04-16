import {useState} from 'react';
import { 
    BrowserRouter, 
    Switch,
    Route
} from 'react-router-dom';

import SideMenu from './parts/SideMenu';
import Header from './parts/Header';
import ReservatinTop from './pages/ReservatinTop';
import Receipt from './pages/Receipt';
import ReceiptSend from './pages/ReceiptSend';
import Evaluation from './pages/Evaluation';
import EvaluationSend from './pages/EvaluationSend';

const Router = () => {
    const [toggle, setToggle] = useState<Boolean>(true);

    // サイドメニュー表示・非表示
    const toggleSideMunu = (): void => {
        setToggle(!toggle);
    }

    return (
        <BrowserRouter>
            <Header toggleSideMunu={ toggleSideMunu }/>

            <div className="">
                <div className={toggle ? "hidden" : "absolute bg-blue-900 min-h-full pt-5 text-white w-52"}>
                    <SideMenu toggleSideMunu={ toggleSideMunu }/>
                </div>

                <div className="100vw bg-gray-200 h-screen pt-5">
                    <div className="ml-2 mr-2">
                        <Switch>
                            <Route path='/admin/receipt/send/:id' render={ () => <ReceiptSend title={'領収書送信'}/> }/>
                            <Route path='/admin/evaluation/send/:id' render={ () => <EvaluationSend title={'評価表送信'}/> }/>
                            <Route path='/admin/reservation' render={ () => <ReservatinTop title={'予約一覧'} /> } />
                            <Route path='/admin/receipt' render={ () => <Receipt title={'領収書'}/> }/>
                            <Route path='/admin/evaluation' render={ () => <Evaluation title={'評価表'}/> }/>
                        </Switch>
                    </div>
                </div>
            </div>
        </BrowserRouter>
    )
}

export default Router