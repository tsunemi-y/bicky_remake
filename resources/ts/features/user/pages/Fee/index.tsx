import React from "react";
import {
  Box,
  Typography,
  Table,
  TableBody,
  TableCell,
  TableContainer,
  TableHead,
  TableRow,
  Paper,
  Stack,
  Divider,
  Alert
} from "@mui/material";

const normalPlanRows = [
  {
    course: "お一人（60分）",
    fee: "8,800円"
  },
  {
    course: "兄弟児同時利用（90分）",
    fee: (
      <>
        13,200円
        <br />
        <Typography variant="body2" color="text.secondary">
          （お一人6,600円）
        </Typography>
      </>
    )
  },
  {
    course: "兄弟児分離利用",
    fee: (
      <>
        8,800円×人数
        <br />
        <Typography variant="body2" color="text.secondary">
          （二名だと120分）
        </Typography>
      </>
    )
  }
];

const juniorPlanRows = [
  {
    course: "通常コース（60分）",
    fee: "8,800円"
  },
  {
    course: "特進コース（90分）",
    fee: "13,200円"
  }
];

const FeePage: React.FC = () => {
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
          href="/fee"
          color="primary"
          sx={{ textDecoration: "none", fontWeight: 500 }}
        >
          料金・プラン
        </Typography>
      </Stack>

      <Typography variant="h4" component="h1" fontWeight="bold" gutterBottom>
        料金・プラン
      </Typography>

      <Typography variant="body1" sx={{ mb: 3 }}>
        ビッキーことば塾では、訓練中に評価した内容を文書にしてお渡ししております。
        <br />
        下記記載の料金は、評価書作成代も含めての料金になります。
        <br />
        ご利用に年齢制限はございません。
        <br />
        大人の方でもご利用できます。
      </Typography>

      {/* 通常プラン */}
      <Box sx={{ mb: 4 }}>
        <Typography variant="h5" fontWeight="bold" gutterBottom>
          通常プラン（現在は土日コースのみ）
        </Typography>
        <TableContainer component={Paper} sx={{ mb: 2 }}>
          <Table>
            <TableHead>
              <TableRow>
                <TableCell align="center" sx={{ fontWeight: "bold", width: "50%" }}>
                  コース
                </TableCell>
                <TableCell align="center" sx={{ fontWeight: "bold", width: "50%" }}>
                  料金
                </TableCell>
              </TableRow>
            </TableHead>
            <TableBody>
              {normalPlanRows.map((row, idx) => (
                <TableRow key={idx}>
                  <TableCell align="center">{row.course}</TableCell>
                  <TableCell align="center">{row.fee}</TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </TableContainer>
        <Typography variant="body2" color="text.secondary">
          ☆兄弟児様で同時ご利用頂ける場合に限り、1回90分で2,200円の割引きが適用されます。
          <br />
          なお、お一人60分で兄弟児様分離（完全個別）でご利用される場合は、通常の8,800円×人数の料金になります。
        </Typography>
      </Box>

      <Divider sx={{ my: 4 }} />

      {/* 中学生限定特別プラン */}
      <Box sx={{ mb: 4 }}>
        <Typography variant="h5" fontWeight="bold" gutterBottom>
          中学生限定特別プラン
        </Typography>
        <TableContainer component={Paper} sx={{ mb: 2 }}>
          <Table>
            <TableHead>
              <TableRow>
                <TableCell align="center" sx={{ fontWeight: "bold", width: "50%" }}>
                  コース
                </TableCell>
                <TableCell align="center" sx={{ fontWeight: "bold", width: "50%" }}>
                  料金
                </TableCell>
              </TableRow>
            </TableHead>
            <TableBody>
              {juniorPlanRows.map((row, idx) => (
                <TableRow key={idx}>
                  <TableCell align="center">{row.course}</TableCell>
                  <TableCell align="center">{row.fee}</TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </TableContainer>
        <Typography variant="body2" color="text.secondary" sx={{ mb: 1 }}>
          通常コースは、60分（30分課題学習+10分コミュニケーショントレーニング+20分保護者からのヒアリング）
          <br />
          特進コースは、90分（50分課題学習+10分コミュニケーショントレーニング+30分保護者からのヒアリング）
          <br />
          となります。
          <br />
          ☆ご予約の際に、どちらかお選び下さい。
          <br />
          ※現在、システムが更新されていない状況ですので、LINEでスタッフに希望日とお時間をお知らせ頂いてから、ご予約をお願い致します。
          <br />
          ご予約時間によっては、90分お取りできない場合もございますので、ご予約希望日時とコースの連絡をLINEにて、お願い致します。
          <br />
          システムの更新は6月下旬予定です。
        </Typography>
      </Box>

      <Divider sx={{ my: 4 }} />

      {/* お支払い方法 */}
      <Box sx={{ mb: 4 }}>
        <Typography variant="h5" fontWeight="bold" gutterBottom>
          お支払い方法について
        </Typography>
        <Alert severity="info" sx={{ mb: 2 }}>
          現在は、現金のみで受け付けております。
          <br />
          おつりのご用意ができません（スムーズに次の方へ引き継ぐためです）
          <br />
          大変お手数をおかけして申し訳ございませんが、あらかじめご用意をお願い致します。
        </Alert>
      </Box>
    </Box>
  );
};

export default FeePage;
