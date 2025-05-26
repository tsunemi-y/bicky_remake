import React from "react";
import {
  Box,
  Typography,
  Stack,
  Divider,
  Paper,
  Link,
  Alert
} from "@mui/material";
import Breadcrumbs from "@mui/material/Breadcrumbs";

const AccessPage: React.FC = () => {
  return (
    <Box sx={{ maxWidth: 800, mx: "auto", p: { xs: 2, sm: 4 } }}>
      {/* パンくずリスト */}
      <Stack direction="row" spacing={1} alignItems="center" sx={{ mb: 2 }}>
        <Breadcrumbs aria-label="breadcrumb">
          <Link underline="hover" color="primary" href="/">
            TOP
          </Link>
          <Typography color="text.primary">アクセス</Typography>
        </Breadcrumbs>
      </Stack>

      <Typography variant="h4" component="h1" fontWeight="bold" gutterBottom>
        アクセス
      </Typography>

      <Divider sx={{ my: 3 }} />

      {/* 住所 */}
      <Box sx={{ mb: 4 }}>
        <Typography variant="h5" fontWeight="bold" gutterBottom>
          住所
        </Typography>
        <Typography variant="body1" sx={{ mb: 2 }}>
          〒618-0015
          <br />
          大阪府三島郡島本町青葉1-7-6
        </Typography>
      </Box>

      {/* 電車でお越しの場合 */}
      <Box sx={{ mb: 4 }}>
        <Typography variant="h5" fontWeight="bold" gutterBottom>
          電車でお越しの場合
        </Typography>
        <Typography variant="body1" sx={{ mb: 2 }}>
          JR島本駅から徒歩5分
          <br />
          阪急水無瀬駅から徒歩9分
        </Typography>
      </Box>

      {/* お車でお越しの場合 */}
      <Box sx={{ mb: 4 }}>
        <Typography variant="h5" fontWeight="bold" gutterBottom>
          お車でお越しの場合
        </Typography>
        <Alert severity="info" sx={{ mb: 2 }}>
          1台分の乗用車駐車スペースがありますが、幅が狭いため、ご注意ください。
          <br />
          ご利用される方は、事前にお声がけいただきますようお願い致します。
        </Alert>
      </Box>

      {/* マップ */}
      <Box>
        <Typography variant="h5" fontWeight="bold" gutterBottom>
          マップ
        </Typography>
        <Box
          sx={{
            width: "100%",
            height: { xs: 300, sm: 400 },
            mb: 2,
            borderRadius: 2,
            overflow: "hidden",
            boxShadow: 2
          }}
        >
          <iframe
            title="アクセスマップ"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3273.099934029152!2d135.66152621458036!3d34.8788367811657!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60010344762683d9%3A0xfdbc7a464365b42c!2z44CSNjE4LTAwMTUg5aSn6Ziq5bqc5LiJ5bO26YOh5bO25pys55S66Z2S6JGJ77yR5LiB55uu77yX4oiS77yW!5e0!3m2!1sja!2sjp!4v1630594432901!5m2!1sja!2sjp"
            width="100%"
            height="100%"
            style={{ border: 0 }}
            allowFullScreen
            loading="lazy"
            referrerPolicy="no-referrer-when-downgrade"
            aria-hidden="false"
          ></iframe>
        </Box>
      </Box>
    </Box>
  );
};

export default AccessPage;
