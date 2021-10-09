import React from 'react';
import SideReservation from './side/SideReservation';
import SideMail from './side/SideMail';

const SideMenu: React.FC = () => {
    return (
        <>
            <h2　className="font-bold font- text-left mx-auto w-4/6">サイドメニュー</h2>
            <ul className="mt-4 mx-auto w-4/6">
                <SideReservation />
                <SideMail />
            </ul>
        </>
    );
}
    
export default SideMenu;

