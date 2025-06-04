import React, { useEffect, useState } from 'react';
import { 
  Box, 
  Container, 
  Typography, 
  Grid, 
  Card, 
  CardContent, 
  CardMedia, 
  Button,
  Paper,
  List,
  ListItem,
  ListItemText,
  Divider,
  Snackbar,
  Alert
} from '@mui/material';
import { Link as RouterLink, useLocation } from 'react-router-dom';
import './styles.module.css';

const newsItems = [
  { date: '2025.04.30', title: 'HPをリニューアルしました' },
];

const services = [
  { title: 'ことばのご相談', subtitle: 'THERAPY FOR LANGUAGE', description: 'ことばの遅れや発話困難など、お悩みに合わせた相談を行います。', to: '/services/language', image: '../img/hero-img.jpg' },
  { title: '学習のご相談', subtitle: 'THERAPY FOR LITERACY', description: '読み書きや学習面でお困りの方へのサポートを行います。', to: '/services/learning', image: '../img/hero-img.jpg' },
  // { title: '発音の指導・大人の発音矯正', subtitle: 'THERAPY FOR SPEECH', description: '音声の明瞭化や発音改善の指導を行います。', to: '/services/pronunciation', image: '../img/hero-img.jpg' },
  // { title: '吃音(きつおん)のご相談', subtitle: 'THERAPY FOR FLUENCY', description: 'どもりにお悩みの方への支援と訓練を提供します。', to: '/services/stuttering', image: '../img/hero-img.jpg' }
];

const UserHome = () => {
  const location = useLocation();
  const [snackbarOpen, setSnackbarOpen] = useState(false);
  const [snackbarMessage, setSnackbarMessage] = useState('');
  const [snackbarSeverity, setSnackbarSeverity] = useState<'success' | 'info' | 'warning' | 'error'>('success');

  useEffect(() => {
    // 予約ページから遷移してきた場合、stateにsnackbar情報があれば表示
    if (location.state && location.state.snackbar) {
      setSnackbarMessage(location.state.snackbar.message || '');
      setSnackbarSeverity(location.state.snackbar.severity || 'success');
      setSnackbarOpen(true);
      // 履歴のstateを消す（戻るボタンで再度表示されないように）
      window.history.replaceState({}, document.title);
    }
  }, [location.state]);

  return (
    <Box>
      {/* ヒーローセクション */}
      <Box className="hero-section">
        <Container maxWidth="lg" disableGutters sx={{ px: 0 }}>
          <Box
            sx={{
              position: 'relative',
              left: '50%',
              right: '50%',
              width: '100vw',
              height: { xs: 300, md: 450 },
              backgroundImage: 'url(../img/hero-img.jpg)',
              backgroundSize: 'cover',
              backgroundPosition: 'center',
              mb: 4,
              transform: 'translateX(-50%)',
              display: 'flex',
              alignItems: 'center',
              justifyContent: 'center',
            }}
          >
            <Box
              sx={{
                position: 'absolute',
                bottom: { xs: 30, md: 50 },
                left: { xs: 20, md: 60 },
                color: '#fff',
                textShadow: '0 2px 8px rgba(0,0,0,0.25)',
                fontWeight: 'bold',
                fontSize: { xs: '1.6rem', md: '2.4rem' },
                letterSpacing: '0.08em',
                lineHeight: 1.5,
                zIndex: 2,
                whiteSpace: 'pre-line',
                fontFamily: '"Noto Sans JP", "メイリオ", Meiryo, sans-serif',
                userSelect: 'none',
              }}
            >
              可能性は、{"\n"}無限大
            </Box>
            {/* オーバーレイで背景を少し暗くする場合 */}
            <Box
              sx={{
                position: 'absolute',
                top: 0,
                left: 0,
                width: '100%',
                height: '100%',
                bgcolor: 'rgba(0,0,0,0.10)',
                zIndex: 1,
              }}
            />
          </Box>
        </Container>
      </Box>

      {/* おしらせセクション */}
      <Container maxWidth="lg">
        <Typography variant="h4" gutterBottom>おしらせ</Typography>
        <Paper elevation={0}>
          <List>
            {newsItems.map((item, idx) => (
              <React.Fragment key={idx}>
                <ListItem>
                  <ListItemText primary={item.date} secondary={item.title} />
                </ListItem>
                {idx < newsItems.length - 1 && <Divider />}
              </React.Fragment>
            ))}
          </List>
        </Paper>
      </Container>

      {/* 相談・指導内容セクション */}
      <Container maxWidth="lg" sx={{ py: 5 }}>
        <Typography variant="h4" gutterBottom>相談・指導内容</Typography>
        <Grid container spacing={4}>
          {services.map((svc, idx) => (
            <Grid key={idx}>
              <Card>
                <CardMedia component="img" height="180" image={svc.image} alt={svc.title} />
                <CardContent>
                  <Typography variant="overline" display="block" gutterBottom>{svc.subtitle}</Typography>
                  <Typography variant="h5" gutterBottom>{svc.title}</Typography>
                  <Typography variant="body2" color="textSecondary">{svc.description}</Typography>
                </CardContent>
                <Box textAlign="center" pb={2}>
                  <Button component={RouterLink} to={svc.to} variant="outlined">詳しくはこちら</Button>
                </Box>
              </Card>
            </Grid>
          ))}
        </Grid>
      </Container>

      {/* 指導の流れセクション */}
      <Container maxWidth="lg" sx={{ py: 5 }}>
        <Typography variant="h4" gutterBottom>指導の流れ</Typography>
        <Typography variant="body2" gutterBottom>※一例であり、ご相談内容によって異なります。</Typography>
        <Grid container spacing={4}>
          {[
            { step: 'STEP 01', title: 'アセスメント', desc: '初回はインテークや検査からアセスメントを実施。2回目以降は、音声などのデータや宿題から振り返りを行います。' },
            { step: 'STEP 02', title: '個別プログラムの実施', desc: '個々のニーズに合わせて作成したプログラムを実施。ご家庭に持ち帰り実践いただける内容のご提案を心掛けています。' },
            { step: 'STEP 03', title: '記録の送付', desc: 'メールで記録を送付。実施記録を共有し、今後にお役立ていただけます。' },
          ].map((flow, idx) => (
            <Grid key={idx}>
              <Typography variant="overline">{flow.step}</Typography>
              <Typography variant="h6">{flow.title}</Typography>
              <Typography variant="body2" color="textSecondary">{flow.desc}</Typography>
            </Grid>
          ))}
        </Grid>
      </Container>

      {/* スナックバー */}
      <Snackbar
        open={snackbarOpen}
        autoHideDuration={4000}
        onClose={() => setSnackbarOpen(false)}
        anchorOrigin={{ vertical: "top", horizontal: "center" }}
      >
        <Alert onClose={() => setSnackbarOpen(false)} severity={snackbarSeverity} sx={{ width: '100%' }}>
          {snackbarMessage}
        </Alert>
      </Snackbar>
    </Box>
  );
};

export default UserHome;
