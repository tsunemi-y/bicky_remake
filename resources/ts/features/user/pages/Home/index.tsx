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
import ArrowForwardIcon from '@mui/icons-material/ArrowForward';
import './style.css';

const Home = () => {
  // お知らせのデータ
  const newsItems = [
    {
      date: '2025.02.11',
      title: '【重要】「ことばの相談室ことり くまもと桜町」が開室します。2025年4月～',
      isImportant: true
    },
    {
      date: '2025.02.09',
      title: 'ことばの相談室ことりのLINEアカウントができました',
      isImportant: false
    },
    {
      date: '2025.01.17',
      title: '小学館HugKum(はぐくむ)様に、当相談室主宰寺田の連載記事が掲載されました',
      isImportant: false
    },
    {
      date: '2025.01.17',
      title: '地域保健WEBにて連載記事が公開されました。',
      isImportant: false
    }
  ];

  // サービス内容
  const services = [
    {
      id: 'language',
      title: 'ことばのご相談',
      subtitle: 'THERAPY FOR LANGUAGE',
      description: '【ことばが遅い】【文で話すのが苦手】【理解しているのに話さない】など、お悩みに応じた「ことばの相談」をお受けします。',
      image: '/images/service-language.jpg'
    },
    {
      id: 'learning',
      title: '学習のご相談',
      subtitle: 'THERAPY FOR LITERACY',
      description: '【書き間違いが多い】【発達性読み書き障害（ディスレクシア）と言われた】などのご相談をお受けしています。',
      image: '/images/service-learning.jpg'
    },
    {
      id: 'pronunciation',
      title: '発音の指導・大人の発音矯正',
      subtitle: 'THERAPY FOR SPEECH',
      description: '【カ行・サ行・ラ行など苦手な発音があり、うまく言えない】などの発音の誤りが対象です。舌や口の位置や動きを適切に導きます。',
      image: '/images/service-speech.jpg'
    },
    {
      id: 'stuttering',
      title: '吃音(きつおん)のご相談',
      subtitle: 'THERAPY FOR FLUENCY',
      description: '【音をくりかえす】【ことばの音を伸ばす】【ことばが詰まる】など、吃音にお悩みの方に向けた支援を行います。',
      image: '/images/service-stuttering.jpg'
    }
  ];

  return (
    <Box className="home-container">
      {/* ヒーローセクション */}
      <Box className="hero-section">
        <Container maxWidth="lg">
          <Box className="hero-content">
            <Typography variant="h1" className="hero-title">
              国家資格・言語聴覚士<br />
              によることばの相談
            </Typography>
            <Typography variant="h2" className="hero-subtitle">
              東京都台東区蔵前・熊本県熊本市中央区桜町
            </Typography>
            <Typography variant="h3" className="hero-brand">
              ことばの相談室ことり
            </Typography>
          </Box>
        </Container>
      </Box>

      {/* お知らせセクション */}
      <Container maxWidth="lg">
        <Box className="section news-section">
          <Typography variant="h2" className="section-title">
            おしらせ
          </Typography>
          <Paper elevation={0} className="news-paper">
            <List>
              {newsItems.map((item, index) => (
                <React.Fragment key={index}>
                  <ListItem alignItems="flex-start" className="news-item">
                    <ListItemText
                      primary={
                        <Box className="news-header">
                          <Typography component="span" className="news-date">
                            {item.date}
                          </Typography>
                          {item.isImportant && (
                            <Typography component="span" className="news-label">
                              重要
                            </Typography>
                          )}
                        </Box>
                      }
                      secondary={
                        <Typography
                          variant="body1"
                          className={`news-title ${item.isImportant ? 'important' : ''}`}
                        >
                          {item.title}
                        </Typography>
                      }
                    />
                  </ListItem>
                  {index < newsItems.length - 1 && <Divider component="li" />}
                </React.Fragment>
              ))}
            </List>
          </Paper>
        </Box>
      </Container>

      {/* 相談室についてセクション */}
      <Box className="about-section">
        <Container maxWidth="lg">
          <Typography variant="h2" className="section-title">
            相談室について
          </Typography>
          <Typography variant="h3" className="about-heading">
            国家資格である言語聴覚士が、ことば・コミュニケーションのご相談をお受けします。
          </Typography>
          <Typography variant="body1" className="about-description">
            ことばがなかなか出ない・文でのお話や説明が苦手・発音が不明瞭・吃音(きつおん)がある・読み書きや学習面が心配、――言語聴覚士がご相談をお受けします。<br /><br />
            レッスンは、言語聴覚士による一人ひとりに合わせたマンツーマンのプログラムです。東京都台東区蔵前、熊本県熊本市中央区桜町での現地対面レッスンのほか、オンラインレッスンにも対応しています。
          </Typography>
          <Button 
            component={RouterLink}
            to="/about"
            variant="outlined"
            color="primary"
            endIcon={<ArrowForwardIcon />}
            className="about-more-button"
          >
            相談室について詳しく見る
          </Button>
          
          <Box className="about-tags">
            {['言語聴覚士', 'オンライン', '教材', 'あいさつ', 'ご相談', 'ことば', 'コミュニケーション'].map((tag, index) => (
              <Typography key={index} component="span" className="tag">
                #{tag}
              </Typography>
            ))}
          </Box>
        </Container>
      </Box>

      {/* 相談・指導内容セクション */}
      <Container maxWidth="lg">
        <Box className="section services-section">
          <Typography variant="h2" className="section-title">
            相談・指導内容
          </Typography>

          <Grid container spacing={4}>
            {services.map((service, index) => (
              <Grid item xs={12} sm={6} md={3} key={index}>
                <Card className="service-card">
                  <CardMedia
                    component="img"
                    height="180"
                    image={service.image}
                    alt={service.title}
                    className="service-image"
                  />
                  <CardContent className="service-content">
                    <Typography variant="overline" className="service-number">
                      {String(index + 1).padStart(2, '0')}
                    </Typography>
                    <Typography variant="overline" className="service-subtitle">
                      {service.subtitle}
                    </Typography>
                    <Typography variant="h5" className="service-title">
                      {service.title}
                    </Typography>
                    <Typography variant="body2" className="service-description">
                      {service.description}
                    </Typography>
                    <Button
                      component={RouterLink}
                      to={`/services/${service.id}`}
                      className="service-button"
                    >
                      詳しくはこちら <ArrowForwardIcon fontSize="small" />
                    </Button>
                  </CardContent>
                </Card>
              </Grid>
            ))}
          </Grid>
        </Box>

        {/* よくある質問セクション */}
        <Box className="section faq-section">
          <Typography variant="h2" className="section-title">
            よくある質問
          </Typography>
          <Grid container spacing={3}>
            <Grid item xs={12} md={6}>
              <Paper elevation={0} className="faq-paper">
                <Typography variant="h6" className="faq-question">
                  診断書は必要ですか？
                </Typography>
                <Typography variant="body1" className="faq-answer">
                  いいえ。必要ありません。<br />
                  医師の診断書や紹介状がなくてもご利用いただけます。自閉症スペクトラムやことばの遅れや吃音などの言語障害は、早期発見・早期介入が望ましいとされています。
                </Typography>
              </Paper>
            </Grid>
            <Grid item xs={12} md={6}>
              <Paper elevation={0} className="faq-paper">
                <Typography variant="h6" className="faq-question">
                  オンラインでも相談できますか？
                </Typography>
                <Typography variant="body1" className="faq-answer">
                  はい。実施しています。<br />
                  オンライン通話サービスのZoomを使用し、外出困難な方、海外や地方にお住まいなど遠方の方のご相談をお受けしています。
                </Typography>
              </Paper>
            </Grid>
          </Grid>
          <Box textAlign="center" mt={4}>
            <Button
              component={RouterLink}
              to="/faq"
              variant="outlined"
              color="primary"
              endIcon={<ArrowForwardIcon />}
            >
              もっと見る
            </Button>
          </Box>
        </Box>

        {/* アクセスセクション */}
        <Box className="section access-section">
          <Typography variant="h2" className="section-title">
            アクセス
          </Typography>
          <Grid container spacing={4}>
            <Grid item xs={12} md={6}>
              <Paper elevation={1} className="access-paper">
                <Typography variant="h6" className="access-title">
                  蔵前 本室
                </Typography>
                <Typography variant="body1" className="access-address">
                  〒111-0051<br />
                  東京都台東区蔵前3丁目21−1 カーサ蔵前 1103号室<br />
                  都営大江戸線 蔵前駅 徒歩3分<br />
                  都営浅草線 蔵前駅 徒歩4分<br />
                  JR総武線浅草橋駅 徒歩15分
                </Typography>
                <Typography variant="body2" className="access-note">
                  駐輪場、駐車場はございません。<br />
                  お近くのサービスをご利用ください。
                </Typography>
                <Button
                  component={RouterLink}
                  to="/reservation"
                  variant="contained"
                  color="primary"
                  className="reservation-button"
                >
                  ご予約はこちら
                </Button>
              </Paper>
            </Grid>
            <Grid item xs={12} md={6}>
              <Paper elevation={1} className="access-paper">
                <Typography variant="h6" className="access-title">
                  熊本相談室
                </Typography>
                <Typography variant="body1" className="access-address">
                  〒860-0805<br />
                  熊本県熊本市中央区桜町1−28 桜町センタービル 406号室<br />
                  熊本市電<br />
                  - 西辛島町 徒歩4分<br />
                  - 花畑町 徒歩5分<br />
                  バス- 熊本桜町バスターミナル下車 3分
                </Typography>
                <Typography variant="body2" className="access-note">
                  駐輪場、駐車場はございません。<br />
                  お近くのサービスをご利用ください。
                </Typography>
                <Button
                  component={RouterLink}
                  to="/reservation"
                  variant="contained"
                  color="primary"
                  className="reservation-button"
                >
                  ご予約はこちら
                </Button>
              </Paper>
            </Grid>
          </Grid>
        </Box>
      </Container>

      {/* CTAセクション */}
      <Box className="cta-section">
        <Container maxWidth="md">
          <Typography variant="h4" align="center" className="cta-title">
            ご予約・お問い合わせ
          </Typography>
          <Typography variant="body1" align="center" className="cta-description">
            ことばの相談、発音指導、学習支援、吃音のご相談など、お気軽にご連絡ください。
          </Typography>
          <Box className="cta-buttons">
            <Button
              component={RouterLink}
              to="/reservation"
              variant="contained"
              color="primary"
              size="large"
              className="cta-button"
            >
              ご予約はこちら
            </Button>
            <Button
              component={RouterLink}
              to="/contact"
              variant="outlined"
              color="primary"
              size="large"
              className="cta-button"
            >
              お問い合わせ
            </Button>
          </Box>
        </Container>
      </Box>
    </Box>
  );
};

export default Home;
