// src/features/user/components/UserLayout/Header.tsx
import { AppBar, Toolbar, Typography, Button, Box } from '@mui/material';
import { Link as RouterLink } from 'react-router-dom';
import styles from './Header.module.css';

const Header = () => {
  return (
    <AppBar position="static" className={styles.header} color="transparent">
      <Toolbar>
        {/* ロゴ */}
        <Typography 
          variant="h6" 
          component={RouterLink} 
          to="/" 
          className={styles.logo}
        >
          ことばの相談室 ことり
        </Typography>
        
        {/* 空白スペース */}
        <Box sx={{ flexGrow: 1 }} />
        
        {/* ナビゲーションメニュー */}
        <Box className={styles.navMenu}>
          <Button component={RouterLink} to="/about">相談室について</Button>
          <Button component={RouterLink} to="/services">サービス内容</Button>
          <Button component={RouterLink} to="/fee">料金</Button>
          <Button component={RouterLink} to="/faq">よくある質問</Button>
          <Button 
            component={RouterLink} 
            to="/reservation" 
            variant="contained" 
            color="primary"
          >
            ご予約はこちら
          </Button>
        </Box>
      </Toolbar>
    </AppBar>
  );
};

export default Header;