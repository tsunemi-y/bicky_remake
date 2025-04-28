import React, { useState } from 'react';
import { 
  AppBar, 
  Toolbar, 
  Typography, 
  Button, 
  Box, 
  Container,
  IconButton,
  Drawer,
  List,
  ListItem,
  ListItemText,
  useMediaQuery,
  useTheme
} from '@mui/material';
import { Link as RouterLink } from 'react-router-dom';
import MenuIcon from '@mui/icons-material/Menu';
import './Header.css';

const Header = () => {
  const theme = useTheme();
  const isMobile = useMediaQuery(theme.breakpoints.down('md'));
  const [mobileOpen, setMobileOpen] = useState(false);

  const handleDrawerToggle = () => {
    setMobileOpen(!mobileOpen);
  };

  const menuItems = [
    { text: '相談・指導内容', path: '/services' },
    { text: 'ことばのご相談', path: '/services/language' },
    { text: '学習のご相談', path: '/services/learning' },
    { text: '発音の指導', path: '/services/pronunciation' },
    { text: '吃音のご相談', path: '/services/stuttering' },
    { text: 'よくある質問', path: '/faq' },
    { text: '相談室について', path: '/about' },
    { text: '料金', path: '/fee' },
  ];

  // モバイル用ドロワーメニュー
  const drawer = (
    <Box onClick={handleDrawerToggle} sx={{ textAlign: 'center' }}>
      <Typography variant="h6" sx={{ my: 2 }}>
        ことばの相談室 ことり
      </Typography>
      <List>
        {menuItems.map((item) => (
          <ListItem key={item.text} component={RouterLink} to={item.path}>
            <ListItemText primary={item.text} />
          </ListItem>
        ))}
        <ListItem>
          <Button
            component={RouterLink}
            to="/reservation"
            variant="contained"
            color="primary"
            fullWidth
          >
            ご予約はこちら
          </Button>
        </ListItem>
      </List>
    </Box>
  );

  return (
    <Box className="header-wrapper">
      <AppBar position="static" color="transparent" elevation={0} className="header">
        <Container maxWidth="lg">
          <Toolbar disableGutters>
            {/* ロゴ */}
            <Typography
              variant="h6"
              component={RouterLink}
              to="/"
              className="logo"
              sx={{ 
                flexGrow: 1,
                textDecoration: 'none',
                color: 'primary.main',
                fontWeight: 'bold'
              }}
            >
              ことばの相談室 ことり
            </Typography>

            {/* デスクトップ用メニュー */}
            {!isMobile && (
              <Box sx={{ display: 'flex' }}>
                {menuItems.map((item, index) => (
                  <Button
                    key={index}
                    component={RouterLink}
                    to={item.path}
                    sx={{ color: 'text.primary', mx: 1 }}
                  >
                    {item.text}
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
                <Button
                  component={RouterLink}
                  to="/contact"
                  variant="outlined"
                  color="primary"
                  sx={{ ml: 1 }}
                >
                  お問い合わせ
                </Button>
              </Box>
            )}

            {/* モバイル用メニューアイコン */}
            {isMobile && (
              <IconButton
                color="inherit"
                aria-label="open drawer"
                edge="start"
                onClick={handleDrawerToggle}
              >
                <MenuIcon />
              </IconButton>
            )}
          </Toolbar>
        </Container>
      </AppBar>

      {/* モバイルメニュードロワー */}
      <Drawer
        variant="temporary"
        open={mobileOpen}
        onClose={handleDrawerToggle}
        ModalProps={{
          keepMounted: true, // モバイルでのパフォーマンス向上
        }}
        sx={{
          display: { xs: 'block', md: 'none' },
          '& .MuiDrawer-paper': { boxSizing: 'border-box', width: 240 },
        }}
      >
        {drawer}
      </Drawer>
    </Box>
  );
};

export default Header;
