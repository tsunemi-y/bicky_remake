// features/user/components/Header/index.tsx
import React, { useState } from 'react';
import {
  AppBar,
  Toolbar,
  Typography,
  Button,
  Box,
  IconButton,
  Drawer,
  List,
  ListItem,
  ListItemButton,
  ListItemText
} from '@mui/material';
import MenuIcon from '@mui/icons-material/Menu';
import { Link as RouterLink } from 'react-router-dom';
import './styles.module.css';

const navLinks = [
  { label: 'ご挨拶', to: '/greeting' },
  { label: '指導員紹介', to: '/introduction' },
  { label: '料金・プラン', to: '/fee' },
  { label: 'アクセス', to: '/access' },
  // { label: 'よくある質問', to: '/faq' },
];

const Header = () => {
  const [mobileOpen, setMobileOpen] = useState(false);

  const handleDrawerToggle = () => {
    setMobileOpen((prev) => !prev);
  };

  // サイドバー（Drawer）からタイトルを削除
  const drawer = (
    <Box onClick={handleDrawerToggle} sx={{ width: 250 }}>
      <List>
        {navLinks.map(({ label, to }) => (
          <ListItem key={to} disablePadding>
            <ListItemButton component={RouterLink} to={to}>
              <ListItemText primary={label} />
            </ListItemButton>
          </ListItem>
        ))}
        <ListItem disablePadding>
          <ListItemButton component={RouterLink} to="/reservation">
            <ListItemText primary="ご予約はこちら" />
          </ListItemButton>
        </ListItem>
      </List>
    </Box>
  );

  return (
    <>
      <AppBar position="static" color="transparent">
        <Toolbar>
          <Typography
            variant="h6"
            component={RouterLink}
            to="/"
            sx={{ flexGrow: 1, textDecoration: 'none', color: 'inherit' }}
          >
            ビッキーことば塾
          </Typography>
          {/* SP: ハンバーガーメニュー */}
          <Box sx={{ display: { xs: 'block', md: 'none' } }}>
            <IconButton
              color="inherit"
              edge="start"
              onClick={handleDrawerToggle}
              aria-label="menu"
            >
              <MenuIcon />
            </IconButton>
          </Box>
          {/* PC: ナビゲーション */}
          <Box sx={{ display: { xs: 'none', md: 'flex' } }}>
            {navLinks.map(({ label, to }) => (
              <Button key={to} component={RouterLink} to={to}>
                {label}
              </Button>
            ))}
            <Button
              component={RouterLink}
              to="/reservation"
              variant="contained"
              color="primary"
              sx={{ ml: 2 }}
            >
              ご予約はこちら
            </Button>
          </Box>
        </Toolbar>
      </AppBar>
      <Drawer
        anchor="left"
        open={mobileOpen}
        onClose={handleDrawerToggle}
        ModalProps={{ keepMounted: true }}
      >
        {drawer}
      </Drawer>
    </>
  );
};

export default Header;