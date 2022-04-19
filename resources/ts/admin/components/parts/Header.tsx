import React, {useState} from 'react';
import { FcMenu } from "react-icons/fc";

const Header: React.FC<any> = (props) => {
    const { toggleSideMunu } = props;
    
    return (
        <>
            <header className="flex h-12">
                <div onClick={toggleSideMunu}><FcMenu size="40px"/></div>
            </header>
        </>
    );
}
    
export default Header;

