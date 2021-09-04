import React from 'react';
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
  Divider
} from '@mui/material';
import { Link as RouterLink } from 'react-router-dom';
import './styles.module.css';

const newsItems = [
  { date: '2025.04.30', title: 'ミラシルby第一生命様に、当相談室主宰寺田の記事が掲載されました' },
  { date: '2025.02.11', title: '【重要】「ことばの相談室ことり くまもと桜町」が開室します。2025年4月～' },
  { date: '2025.02.09', title: 'ことばの相談室ことりのLINEアカウントができました' },
  { date: '2025.01.17', title: '小学館HugKum(はぐくむ)様に、当相談室主宰寺田の連載記事が掲載されました' },
  { date: '2025.01.17', title: '地域保健WEBにて連載記事が公開されました。' }
];

const services = [
  { title: 'ことばのご相談', subtitle: 'THERAPY FOR LANGUAGE', description: 'ことばの遅れや発話困難など、お悩みに合わせた相談を行います。', to: '/services/language', image: '/images/service-language.jpg' },
  { title: '学習のご相談', subtitle: 'THERAPY FOR LITERACY', description: '読み書きや学習面でお困りの方へのサポートを行います。', to: '/services/learning', image: '/images/service-learning.jpg' },
  { title: '発音の指導・大人の発音矯正', subtitle: 'THERAPY FOR SPEECH', description: '音声の明瞭化や発音改善の指導を行います。', to: '/services/pronunciation', image: '/images/service-speech.jpg' },
  { title: '吃音(きつおん)のご相談', subtitle: 'THERAPY FOR FLUENCY', description: 'どもりにお悩みの方への支援と訓練を提供します。', to: '/services/stuttering', image: '/images/service-stuttering.jpg' }
];

const UserHome = () => (
  <Box>
    {/* ヒーローセクション */}
    <Box className="hero-section">
      <Container maxWidth="lg">
        <Box
          sx={{
            width: '100%',
            height: { xs: 200, md: 400 },
            backgroundImage: 'url(/images/hero.jpg)',
            backgroundSize: 'cover',
            backgroundPosition: 'center',
            mb: 4,
          }}
        />
        <Typography variant="h1">国家資格・言語聴覚士によることばの相談</Typography>
        <Typography variant="h2">東京都台東区蔵前・熊本県熊本市中央区桜町</Typography>
        <Typography variant="h3">ことばの相談室ことり</Typography>
      </Container>
    </Box>

    {/* おしらせセクション */}
    <Container maxWidth="lg" sx={{ py: 5 }}>
      <Typography variant="h2" gutterBottom>おしらせ</Typography>
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
      <Typography variant="h2" gutterBottom>相談・指導内容</Typography>
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
      <Typography variant="h2" gutterBottom>指導の流れ</Typography>
      <Typography variant="body2" gutterBottom>※一例であり、ご相談内容によって異なります。</Typography>
      <Grid container spacing={4}>
        {[
          { step: 'STEP 01', title: 'アセスメント', desc: '初回はインテークや検査からアセスメントを実施。2回目以降は、音声などのデータや宿題から振り返りを行います。' },
          { step: 'STEP 02', title: '個別プログラムの実施', desc: '個々のニーズに合わせて作成したプログラムを実施。ご家庭に持ち帰り実践いただける内容のご提案を心掛けています。' },
          { step: 'STEP 03', title: '記録の送付', desc: 'メールで記録を送付。実施記録を共有し、今後にお役立ていただけます。' },
          { step: 'STEP 04', title: '音声データなどの相互共有', desc: '必要に応じて、ご家庭で過ごす期間にも遠隔でのやり取りを継続いたします（1〜2往復めやす）。' }
        ].map((flow, idx) => (
          <Grid key={idx}>
            <Typography variant="overline">{flow.step}</Typography>
            <Typography variant="h6">{flow.title}</Typography>
            <Typography variant="body2" color="textSecondary">{flow.desc}</Typography>
          </Grid>
        ))}
      </Grid>
    </Container>
  </Box>
);

export default UserHome;
