// features/user/components/Footer/index.tsx
import React from 'react';
import { Box, Container, Grid, Typography, Link } from '@mui/material';
import { Link as RouterLink } from 'react-router-dom';

const Footer = () => {
  const menuItems = [
    {
      title: '相談・指導内容',
      items: [
        { label: 'ことばのご相談', path: '/services/language' },
        { label: '学習のご相談', path: '/services/learning' },
        { label: '発音の指導・大人の発音矯正', path: '/services/pronunciation' },
        { label: '吃音(きつおん)のご相談', path: '/services/stuttering' },
        { label: 'よくある質問', path: '/faq' }
      ]
    },
    {
      title: '相談室について',
      items: [
        { label: '代表あいさつ', path: '/about/greeting' },
        { label: 'スタッフ紹介', path: '/about/staff' },
        { label: 'ご利用規定', path: '/about/terms' },
        { label: '所在地', path: '/about/location' }
      ]
    },
    {
      title: '料金',
      items: [
        { label: 'ご相談料金', path: '/fee/consultation' },
        { label: '各種検査にかかる費用', path: '/fee/examination' },
        { label: 'コトリドリル', path: '/fee/drill' }
      ]
    }
  ];

  return (
    <Box component="footer" sx={{ bgcolor: 'background.paper', py: 6 }}>
      <Container maxWidth="lg">
        <Grid container spacing={4}>
          {menuItems.map((section, index) => (
            <Grid key={index}>
              <Typography variant="h6" gutterBottom>
                {section.title}
              </Typography>
              {section.items.map((item, itemIndex) => (
                <Typography variant="body2" key={itemIndex}>
                  <Link
                    component={RouterLink}
                    to={item.path}
                    color="textSecondary"
                    sx={{ textDecoration: 'none', '&:hover': { textDecoration: 'underline' } }}
                  >
                    {item.label}
                  </Link>
                </Typography>
              ))}
            </Grid>
          ))}
        </Grid>

        <Box mt={5}>
          <Typography variant="h6" gutterBottom>
            ビッキーことば塾
          </Typography>
          <Typography variant="body2" color="textSecondary">
            〒111-0051<br />
            東京都台東区蔵前3丁目21−1 カーサ蔵前 1103号室
          </Typography>
          <Typography variant="body2" color="textSecondary" mt={2}>
            〒860-0805<br />
            熊本県熊本市中央区桜町1-28 桜町センタービル 406号室
          </Typography>
        </Box>

        <Typography variant="body2" color="textSecondary" align="center" mt={3}>
          © KOTOBANOSOUDANSHITSU KOTORI
        </Typography>
      </Container>
    </Box>
  );
};

export default Footer;