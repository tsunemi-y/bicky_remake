import React from 'react';
import SideReservation from './side/SideReservation';
import SideMail from './side/SideMail';

const SideMenu: React.FC<any> = (props) => {
    const { toggleSideMunu } = props;
    return (
        <>
            <h2 className="font-bold font- text-left mx-auto w-4/6">サイドメニュー</h2>
            <ul className="mt-4 mx-auto w-4/6">
                <SideReservation toggleSideMunu={ toggleSideMunu }/>
                <SideMail toggleSideMunu={ toggleSideMunu }/>
            </ul>
        </>
    );
}
    
export default SideMenu;

