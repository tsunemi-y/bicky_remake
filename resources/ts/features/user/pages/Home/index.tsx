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
  { title: 'ことばのご相談', subtitle: 'THERAPY FOR LANGUAGE', description: 'ことばの遅れや発話困難など、お悩みに合わせた相談を行います。', to: '/services/language', image: 'https://readdy.ai/api/search-image?query=A%20kawaii%20style%20Japanese%20illustration%20of%20a%20cheerful%20playroom%20interior.%20The%20scene%20features%20cute%20cartoon%20style%20furniture%20and%20toys%2C%20with%20soft%20pastel%20colors%20and%20playful%20Japanese%20design%20elements.%20Decorated%20with%20adorable%20mascot%20characters%2C%20rainbow%20motifs%2C%20and%20floating%20musical%20notes.%20The%20illustration%20has%20a%20warm%20and%20welcoming%20atmosphere%20with%20Japanese%20aesthetic%20touches%20and%20child%20friendly%20elements.&width=400&height=300&seq=facility1&orientation=landscape' },
  { title: '学習のご相談', subtitle: 'THERAPY FOR LITERACY', description: '読み書きや学習面でお困りの方へのサポートを行います。', to: '/services/learning', image: 'https://readdy.ai/api/search-image?query=A%20cute%20Japanese%20anime%20style%20illustration%20showing%20caring%20teachers%20working%20with%20children.%20The%20scene%20features%20kawaii%20style%20characters%20with%20gentle%20expressions%20and%20soft%20pastel%20colors.%20The%20illustration%20includes%20educational%20elements%20like%20floating%20books%20and%20numbers%2C%20decorated%20with%20heart%20shapes%20and%20star%20motifs.%20The%20background%20has%20a%20gentle%20gradient%20with%20Japanese%20pattern%20elements%20creating%20a%20warm%20educational%20atmosphere.&width=400&height=300&seq=facility2&orientation=landscape' },
  // { title: '発音の指導・大人の発音矯正', subtitle: 'THERAPY FOR SPEECH', description: '音声の明瞭化や発音改善の指導を行います。', to: '/services/pronunciation', image: '../img/hero-img.jpg' },
  // { title: '吃音(きつおん)のご相談', subtitle: 'THERAPY FOR FLUENCY', description: 'どもりにお悩みの方への支援と訓練を提供します。', to: '/services/stuttering', image: '../img/hero-img.jpg' }
];

const MAIL_ADDRESS = 'mailto:info@hattatsushien0724@gmail.com';
const RESERVE_URL = '/reservation';

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
    <Box sx={{ pb: 0 }}>
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
              backgroundImage: 'url(https://vicky-s3-bucket-20250722.s3.ap-northeast-1.amazonaws.com/hero-img.jpg)',
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
          {snackbarMessage.split('\n').map((line, index) => (
            <React.Fragment key={index}>
              {line}
              {index !== snackbarMessage.split('\n').length - 1 && <br />}
            </React.Fragment>
          ))}
        </Alert>
      </Snackbar>

      {/* スティッキーフッター */}
      <Box
        sx={{
          position: 'fixed',
          left: '50%',
          bottom: 0,
          transform: 'translateX(-50%)',
          width: '100vw',
          bgcolor: '#fff',
          borderTop: '1px solid #e0e0e0',
          boxShadow: '0 -4px 20px rgba(0,0,0,0.1)',
          zIndex: 2000,
          py: { xs: 1, md: 1.5 },
          px: { xs: 1, md: 3 },
        }}
      >
        <Container maxWidth="lg" sx={{ p: '0 !important' }}>
          <Box
            sx={{
              display: 'flex',
              justifyContent: 'center',
              alignItems: 'center',
              gap: { xs: 2, md: 4 },
              flexWrap: 'nowrap',
              width: '100%',
              px: { xs: 0.5, md: 0 },
            }}
          >
            <Button
              variant="contained"
              href={MAIL_ADDRESS}
              sx={{
                minWidth: { xs: 140, md: 200 },
                maxWidth: { xs: 180, md: 220 },
                minHeight: { xs: 42, md: 48 },
                backgroundColor: '#1976d2',
                color: '#fff',
                fontWeight: 'bold',
                fontSize: { xs: '0.9rem', md: '1rem' },
                borderRadius: { xs: 3, md: 4 },
                textTransform: 'none',
                boxShadow: '0 3px 12px rgba(25, 118, 210, 0.3)',
                '&:hover': {
                  backgroundColor: '#1565c0',
                  boxShadow: '0 5px 16px rgba(25, 118, 210, 0.4)',
                  transform: 'translateY(-2px)',
                },
                transition: 'all 0.3s ease-in-out',
              }}
            >
              メールで相談
            </Button>
            
            <Button
              variant="contained"
              component={RouterLink}
              to={RESERVE_URL}
              sx={{
                minWidth: { xs: 140, md: 200 },
                maxWidth: { xs: 180, md: 220 },
                minHeight: { xs: 42, md: 48 },
                backgroundColor: '#f57c00',
                color: '#fff',
                fontWeight: 'bold',
                fontSize: { xs: '0.9rem', md: '1rem' },
                borderRadius: { xs: 3, md: 4 },
                textTransform: 'none',
                boxShadow: '0 3px 12px rgba(245, 124, 0, 0.3)',
                '&:hover': {
                  backgroundColor: '#ef6c00',
                  boxShadow: '0 5px 16px rgba(245, 124, 0, 0.4)',
                  transform: 'translateY(-2px)',
                },
                transition: 'all 0.3s ease-in-out',
              }}
            >
              予約ページへ
            </Button>
          </Box>
        </Container>
      </Box>
    </Box>
  );
};

export default UserHome;
