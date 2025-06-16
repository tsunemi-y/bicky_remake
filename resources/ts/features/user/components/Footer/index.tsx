// features/user/components/Footer/index.tsx
import React from 'react';
import { Box, Container, Grid, Typography, Link, Divider } from '@mui/material';
import { Link as RouterLink } from 'react-router-dom';

const menuItems = [
  {
    title: 'ご相談・指導内容',
    items: [
      { label: 'ご挨拶', path: '/greeting' },
      { label: '指導員紹介', path: '/introduction' },
      { label: '料金・プラン', path: '/fee' },
      { label: 'アクセス', path: '/access' },
    ],
  },
  {
    title: 'ご予約・お問い合わせ',
    items: [
      { label: 'ご予約はこちら', path: '/reservation' },
      // { label: 'よくある質問', path: '/faq' },
    ],
  },
];

const Footer = () => {
  return (
    <Box
      component="footer"
      sx={{
        borderTop: '4px solid #72cc82',
        mt: 8,
        pt: 6,
        pb: 3,
      }}
    >
      <Container maxWidth="lg">
        <Grid container spacing={4} justifyContent="center">
          {menuItems.map((section, idx) => (
            <Grid key={idx}>
              <Typography
                variant="subtitle1"
                fontWeight="bold"
                color="primary"
                gutterBottom
                sx={{ letterSpacing: 1, mb: 1 }}
              >
                {section.title}
              </Typography>
              {section.items.map((item, itemIdx) => (
                <Typography variant="body2" key={itemIdx} sx={{ mb: 0.5 }}>
                  <Link
                    component={RouterLink}
                    to={item.path}
                    color="inherit"
                    sx={{
                      textDecoration: 'none',
                      '&:hover': { textDecoration: 'underline', color: '#72cc82' },
                      transition: 'color 0.2s',
                    }}
                  >
                    {item.label}
                  </Link>
                </Typography>
              ))}
            </Grid>
          ))}
        </Grid>

        <Divider sx={{ my: 4, borderColor: '#72cc82', opacity: 0.5 }} />

        <Box textAlign="center" sx={{ mb: 2 }}>
          <Typography
            variant="h6"
            fontWeight="bold"
            color="primary"
            sx={{ letterSpacing: 2, mb: 1 }}
          >
            ビッキーことば塾
          </Typography>
          <Typography variant="body2" color="text.secondary">
            〒618-0015 大阪府三島郡島本町青葉1-7-6
          </Typography>
        </Box>

        <Typography
          variant="caption"
          color="text.secondary"
          align="center"
          display="block"
          sx={{ mt: 2, letterSpacing: 1 }}
        >
          Copyright (c) bicky All Rights Reserved.
        </Typography>
      </Container>
    </Box>
  );
};

export default Footer;