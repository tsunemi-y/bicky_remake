import React from 'react';
import { 
  Box, 
  Container, 
  Grid, 
  Typography, 
  Link,
  List,
  ListItem,
  Button,
  Divider
} from '@mui/material';
import { Link as RouterLink } from 'react-router-dom';
import LocationOnIcon from '@mui/icons-material/LocationOn';
import PhoneIcon from '@mui/icons-material/Phone';
import './Footer.css';

const Footer = () => {
  const currentYear = new Date().getFullYear();
  
  const serviceLinks = [
    { text: 'ことばのご相談', path: '/services/language' },
    { text: '学習のご相談', path: '/services/learning' },
    { text: '発音の指導', path: '/services/pronunciation' },
    { text: '吃音のご相談', path: '/services/stuttering' },
    { text: 'よくある質問', path: '/faq' },
  ];
  
  const aboutLinks = [
    { text: '代表あいさつ', path: '/about/message' },
    { text: 'スタッフ紹介', path: '/about/staff' },
    { text: 'ご利用規定', path: '/about/rules' },
    { text: '所在地', path: '/about/access' },
  ];
  
  const otherLinks = [
    { text: '料金', path: '/fee' },
    { text: '法人のお客さま', path: '/corporate' },
    { text: '採用情報', path: '/careers' },
  ];

  return (
    <Box component="footer" className="footer">
      <Container maxWidth="lg">
        <Grid container spacing={4} className="footer-content">
          {/* ロゴと説明 */}
          <Grid item xs={12} md={4}>
            <Typography variant="h6" component={RouterLink} to="/" className="footer-logo">
              ことばの相談室 ことり
            </Typography>
            <Box mt={2}>
              <Box className="address-item">
                <LocationOnIcon fontSize="small" />
                <Typography variant="body2">
                  〒111-0051<br />
                  東京都台東区蔵前3丁目21−1 カーサ蔵前 1103号室
                </Typography>
              </Box>
              <Box className="address-item" mt={1}>
                <LocationOnIcon fontSize="small" />
                <Typography variant="body2">
                  〒860-0805<br />
                  熊本県熊本市中央区桜町1−28 桜町センタービル 406号室
                </Typography>
              </Box>
            </Box>
            <Box mt={3}>
              <Button 
                component={RouterLink} 
                to="/reservation" 
                variant="contained" 
                color="primary" 
                fullWidth
                className="footer-button"
              >
                ご予約はこちら
              </Button>
              <Button 
                component={RouterLink}
                to="/contact" 
                variant="outlined" 
                color="primary" 
                fullWidth
                sx={{ mt: 1 }}
                className="footer-button"
              >
                お問い合わせ
              </Button>
            </Box>
          </Grid>
          
          {/* リンクセクション */}
          <Grid item xs={12} md={8}>
            <Grid container spacing={2}>
              {/* 相談・指導内容 */}
              <Grid item xs={12} sm={4}>
                <Typography variant="subtitle1" className="footer-heading">
                  相談・指導内容
                </Typography>
                <List dense disablePadding>
                  {serviceLinks.map((link, index) => (
                    <ListItem key={index} disablePadding className="footer-list-item">
                      <Link 
                        component={RouterLink} 
                        to={link.path}
                        underline="hover"
                        color="inherit"
                      >
                        {link.text}
                      </Link>
                    </ListItem>
                  ))}
                </List>
              </Grid>
              
              {/* 相談室について */}
              <Grid item xs={12} sm={4}>
                <Typography variant="subtitle1" className="footer-heading">
                  相談室について
                </Typography>
                <List dense disablePadding>
                  {aboutLinks.map((link, index) => (
                    <ListItem key={index} disablePadding className="footer-list-item">
                      <Link 
                        component={RouterLink} 
                        to={link.path}
                        underline="hover"
                        color="inherit"
                      >
                        {link.text}
                      </Link>
                    </ListItem>
                  ))}
                </List>
              </Grid>
              
              {/* その他 */}
              <Grid item xs={12} sm={4}>
                <Typography variant="subtitle1" className="footer-heading">
                  その他
                </Typography>
                <List dense disablePadding>
                  {otherLinks.map((link, index) => (
                    <ListItem key={index} disablePadding className="footer-list-item">
                      <Link 
                        component={RouterLink} 
                        to={link.path}
                        underline="hover"
                        color="inherit"
                      >
                        {link.text}
                      </Link>
                    </ListItem>
                  ))}
                </List>
              </Grid>
            </Grid>
          </Grid>
        </Grid>
        
        <Divider sx={{ mt: 4, mb: 2 }} />
        
        {/* コピーライト */}
        <Typography variant="body2" align="center" className="copyright">
          © {currentYear} KOTOBANOSOUDANSHITSU KOTORI
        </Typography>
      </Container>
    </Box>
  );
};

export default Footer;
