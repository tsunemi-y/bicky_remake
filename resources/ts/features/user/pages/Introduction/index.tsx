import React from "react";
import {
  Box,
  Typography,
  Stack,
  Paper,
} from "@mui/material";

const IntroductionPage: React.FC = () => {
  return (
    <Box sx={{ maxWidth: 800, mx: "auto", p: { xs: 2, sm: 4 } }}>
      {/* パンくずリスト */}
      <Stack direction="row" spacing={1} alignItems="center" sx={{ mb: 2 }}>
        <Typography
          component="a"
          href="/"
          color="primary"
          sx={{ textDecoration: "none", fontWeight: 500 }}
        >
          TOP
        </Typography>
        <Typography color="text.disabled">{">"}</Typography>
        <Typography
          component="a"
          href="/introduction"
          color="primary"
          sx={{ textDecoration: "none", fontWeight: 500 }}
        >
          指導員紹介
        </Typography>
      </Stack>

      <Typography variant="h4" component="h1" fontWeight="bold" gutterBottom>
        指導員紹介
      </Typography>

      <Box sx={{ display: "flex", justifyContent: "center", mb: 4 }}>
        <img
          src="https://bicky.herokuapp.com/img/staff.png"
          alt="言語聴覚士・保育士・高等学校教諭の免許を持った指導員です。"
          style={{ maxWidth: "100%", height: "auto", borderRadius: 8 }}
        />
      </Box>

      <Paper elevation={2} sx={{ p: { xs: 2, sm: 3 }, mb: 4 }}>
        <Typography
          variant="h5"
          fontWeight="bold"
          gutterBottom
          sx={{ letterSpacing: 2, textTransform: "uppercase" }}
        >
          TSUNEMI NATSUKO
        </Typography>
        <Typography
          variant="subtitle1"
          fontWeight="bold"
          color="primary"
          sx={{ mb: 2, letterSpacing: 1, textTransform: "uppercase" }}
        >
          言語聴覚士 / 保育士 / 高等学校教諭 / 介護福祉士
        </Typography>
        <Typography variant="body1" sx={{ mb: 1 }}>
          関西学院大学卒業
        </Typography>
      </Paper>

      <Paper elevation={2} sx={{ p: { xs: 2, sm: 3 } }}>
        <Typography
          variant="h5"
          fontWeight="bold"
          gutterBottom
          sx={{ letterSpacing: 2, textTransform: "uppercase" }}
        >
          CAREER
        </Typography>
        <Typography variant="body1" sx={{ mb: 2 }}>
          小学校から始めた剣道を20年間続ける。
        </Typography>
        <Typography variant="body1" sx={{ mb: 2 }}>
          中学校では近畿大会、
          <br />
          高等学校では全国大会、
          <br />
          大学では都道府県大会の兵庫県代表で出場
        </Typography>
        <Typography variant="body1" sx={{ mb: 2 }}>
          中学校、高等学校、大学で剣道部主将を務める。
          <br />
          教員退職後は、訪問介護事業の開設に携わる。
          <br />
          児童発達支援事業で言語聴覚士としてことばの訓練及び療育を行う。
          <br />
          現在、民間事業ビッキーことば塾でことばの訓練を行う。
        </Typography>
      </Paper>
    </Box>
  );
};

export default IntroductionPage;
