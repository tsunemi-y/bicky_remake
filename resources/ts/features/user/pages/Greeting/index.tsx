import React from "react";
import {
  Box,
  Typography,
  Paper,
  Stack,
  Divider,
  Breadcrumbs,
  Link as MuiLink,
} from "@mui/material";

import { Link as RouterLink } from "react-router-dom";

const breadcrumbItems = [
  { label: "TOP", href: "/" },
  { label: "ご挨拶", href: "/greeting" },
];

const GreetingPage: React.FC = () => {
  return (
    <Box sx={{ maxWidth: 800, mx: "auto", p: { xs: 2, sm: 4 } }}>
      <Box sx={{ mt: 3, mb: 2 }}>
        <Breadcrumbs aria-label="breadcrumb">
          <MuiLink component={RouterLink} underline="hover" color="inherit" to="/">
            TOP
          </MuiLink>
          <Typography color="text.primary">ご挨拶</Typography>
        </Breadcrumbs>
      </Box>

      <Typography
        variant="h4"
        component="h1"
        fontWeight="bold"
        gutterBottom
        sx={{ mb: 3 }}
      >
        ご挨拶
      </Typography>

      <Paper elevation={0} sx={{ p: { xs: 2, sm: 3 }, mb: 4, background: "none" }}>
        <Typography variant="body1" sx={{ mb: 2, fontSize: 18, lineHeight: 2 }}>
          令和4年4月から島本町の地で、民間事業ビッキーことば塾を開設することとなりました。
          <br />
          障害の有無に関わらず、お子様方が自分らしく生活の質を高めていけるようにサポートさせて頂きたいと考えています。
          <br />
          ことば塾は、親御様の相談所の役割もあります。
          <br />
          ひとりひとりに合う子育てを一緒に考えていきましょう。
        </Typography>
      </Paper>

      <Divider sx={{ my: 4 }} />

      <section className="mb-4">
        <Typography variant="h5" fontWeight="bold" gutterBottom>
          方針
        </Typography>
        <Typography variant="body1" sx={{ mb: 2, lineHeight: 2 }}>
          最近、ニュースでよく取り上げられている「虐待」に対する課題は増える一方です。
          <br />
          虐待は親御様が一生懸命しつけや子育てをしていく中で生まれるものもあります。
          <br />
          「言う事を聞いてくれない」という悩みはどのご家庭でもあるかと思います。
          <br />
          核家族化が進み子育ての仕方が分からない方や、一人で子育てをして孤独を感じている方も少なくはありません。
          <br />
          大切なお子様を「楽しく育てたい」という思いは誰もが願っていることだと思います。
          <br />
          そのためには、お子様の性格や特性の理解、発達段階に応じた手助けが必要になってきます。
          <br />
          まずは、お子様を育てやすくする環境を作っていくことが大切です。
          <br />
          そうすることが、お子様にとっても生活しやすくなります。
          <br />
          「子供がいうことを聞いてくれない」と親御様が思っているように子供たちもまた「誰も自分のことを分かってくれない。」と嘆いている可能性もあります。
          <br />
          ビッキーことば塾は障がいの有無に関係なく訓練を受けていただくことができます。
          <br />
          多くのことを吸収できるこの大切な時期に、将来の見通しを立てながら計画的に子育てしていきましょう。
          <br />
          ビッキーことば塾では、得意なことを伸ばして苦手なことにもチャレンジできる強い心と安定した心を養い人間力（社会で生きていくための力）を鍛えます。
          <br />
          それぞれの能力が最大限引き出せるよう、個別指導及びペアレント指導ではマンツーマンの訓練を行います。
          <br />
          集団指導では、小集団での遊びを通して対人コミュニケーション力を身に付けてもらいます。
        </Typography>
      </section>

      <Divider sx={{ my: 4 }} />

      <section className="mb-4">
        <Typography variant="h5" fontWeight="bold" gutterBottom>
          民間事業のメリット
        </Typography>
        <Typography variant="body1" sx={{ mb: 2, lineHeight: 2 }}>
          ・一人でも多くのお子様が適切な時期に言語訓練を受ける環境を作るため。
          <br />
          ・年齢や障がいの有無に関わらず言語訓練が受けられるようにするため。
          <br />
          ・療育の並行利用を可能にするため。（同日に利用可能）
        </Typography>
      </section>

      <Divider sx={{ my: 4 }} />

      <section>
        <Typography variant="h5" fontWeight="bold" gutterBottom>
          事業の目的
        </Typography>
        <Typography variant="body1" sx={{ lineHeight: 2 }}>
          ・生活の質の向上
          <br />
          ・自己肯定感を養い、安定した精神状態で生活することができる。
          <br />
          ・小学校等での学習の遅れを支援する。
          <br />
          ・自らの特性等を理解し、想定外の出来事にも対応できる力を育てる。
          <br />
          ・自分らしく生きる力を育てる。
          <br />
          ・将来の就労に繋がる特技（能力）を見つける。
        </Typography>
      </section>
    </Box>
  );
};

export default GreetingPage;
