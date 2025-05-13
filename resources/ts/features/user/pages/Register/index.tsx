import React, { useState } from 'react';
import { 
  Container, 
  Typography, 
  Box, 
  TextField, 
  Button, 
  Grid, 
  Radio, 
  RadioGroup, 
  FormControlLabel, 
  FormControl, 
  FormLabel, 
  Checkbox,
  Paper,
  Divider,
  InputAdornment,
  IconButton
} from '@mui/material';
import Visibility from '@mui/icons-material/Visibility';
import VisibilityOff from '@mui/icons-material/VisibilityOff';
import './style.css';

const Register = () => {
  // パスワード表示/非表示の状態
  const [showPassword, setShowPassword] = useState(false);
  const [showPasswordConfirm, setShowPasswordConfirm] = useState(false);

  // フォームの状態
  const [formValues, setFormValues] = useState({
    parentName: '',
    parentNameKana: '',
    email: '',
    tel: '',
    password: '',
    passwordConfirmation: '',
    childName: '',
    childNameKana: '',
    age: '',
    gender: '男の子',
    diagnosis: '',
    postCode: '',
    address: '',
    lineConsultation: false,
    introduction: '',
    consultation: ''
  });

  // エラー状態
  const [errors, setErrors] = useState<Record<string, string>>({});

  // フォームの入力変更ハンドラ
  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value, type, checked } = e.target;
    setFormValues({
      ...formValues,
      [name]: type === 'checkbox' ? checked : value
    });
  };

  // フォーム送信ハンドラ
  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    // バリデーション
    const newErrors: Record<string, string> = {};
    
    // 必須項目チェック
    if (!formValues.parentName) newErrors.parentName = '保護者氏名は必須項目です';
    if (!formValues.parentNameKana) newErrors.parentNameKana = '保護者氏名（カナ）は必須項目です';
    if (!formValues.email) newErrors.email = 'メールアドレスは必須項目です';
    if (!formValues.tel) newErrors.tel = '電話番号は必須項目です';
    if (!formValues.password) newErrors.password = 'パスワードは必須項目です';
    if (formValues.password !== formValues.passwordConfirmation) {
      newErrors.passwordConfirmation = 'パスワードが一致しません';
    }
    if (!formValues.childName) newErrors.childName = '利用児氏名は必須項目です';
    if (!formValues.childNameKana) newErrors.childNameKana = '利用児氏名（カナ）は必須項目です';
    if (!formValues.age) newErrors.age = '利用児年齢は必須項目です';
    if (!formValues.postCode) newErrors.postCode = '郵便番号は必須項目です';
    if (!formValues.address) newErrors.address = '住所は必須項目です';

    // パスワード形式チェック
    if (formValues.password && (formValues.password.length < 8 || !/^[a-zA-Z0-9]+$/.test(formValues.password))) {
      newErrors.password = 'パスワードは8桁の半角英数字で入力してください';
    }

    setErrors(newErrors);

    // エラーがなければ送信処理
    if (Object.keys(newErrors).length === 0) {
      console.log('送信データ:', formValues);
      // TODO: API送信処理を実装
      alert('登録処理が完了しました。');
    }
  };

  // パスワード表示切り替え
  const handleClickShowPassword = () => {
    setShowPassword(!showPassword);
  };

  const handleClickShowPasswordConfirm = () => {
    setShowPasswordConfirm(!showPasswordConfirm);
  };

  return (
    <Container maxWidth="md" className="register-container">
      <Paper elevation={3} className="register-paper">
        <Typography variant="h4" component="h1" align="center" gutterBottom className="register-title">
          新規登録
        </Typography>
        <Divider sx={{ mb: 4 }} />

        <Box component="form" onSubmit={handleSubmit} noValidate>
          <Typography variant="h6" gutterBottom className="section-title">
            保護者情報
          </Typography>

          <Grid container spacing={3}>
            <Grid item xs={12}>
              <TextField
                required
                fullWidth
                id="parentName"
                name="parentName"
                label="保護者氏名"
                placeholder="田中太郎"
                value={formValues.parentName}
                onChange={handleChange}
                error={!!errors.parentName}
                helperText={errors.parentName}
              />
            </Grid>

            <Grid item xs={12}>
              <TextField
                required
                fullWidth
                id="parentNameKana"
                name="parentNameKana"
                label="保護者氏名（カナ）"
                placeholder="タナカタロウ"
                value={formValues.parentNameKana}
                onChange={handleChange}
                error={!!errors.parentNameKana}
                helperText={errors.parentNameKana}
              />
            </Grid>

            <Grid item xs={12}>
              <TextField
                required
                fullWidth
                id="email"
                name="email"
                label="メールアドレス"
                type="email"
                placeholder="name@example.com"
                value={formValues.email}
                onChange={handleChange}
                error={!!errors.email}
                helperText={errors.email}
              />
            </Grid>

            <Grid item xs={12}>
              <TextField
                required
                fullWidth
                id="tel"
                name="tel"
                label="電話番号"
                placeholder="08012345678"
                value={formValues.tel}
                onChange={handleChange}
                error={!!errors.tel}
                helperText={errors.tel || "※ハイフンなしでご入力ください"}
              />
            </Grid>

            <Grid item xs={12}>
              <TextField
                required
                fullWidth
                id="password"
                name="password"
                label="パスワード"
                type={showPassword ? 'text' : 'password'}
                value={formValues.password}
                onChange={handleChange}
                error={!!errors.password}
                helperText={errors.password || "※8桁の半角英数字でご入力ください"}
                InputProps={{
                  endAdornment: (
                    <InputAdornment position="end">
                      <IconButton
                        aria-label="toggle password visibility"
                        onClick={handleClickShowPassword}
                        edge="end"
                      >
                        {showPassword ? <VisibilityOff /> : <Visibility />}
                      </IconButton>
                    </InputAdornment>
                  )
                }}
              />
            </Grid>

            <Grid item xs={12}>
              <TextField
                required
                fullWidth
                id="passwordConfirmation"
                name="passwordConfirmation"
                label="パスワード確認"
                type={showPasswordConfirm ? 'text' : 'password'}
                value={formValues.passwordConfirmation}
                onChange={handleChange}
                error={!!errors.passwordConfirmation}
                helperText={errors.passwordConfirmation}
                InputProps={{
                  endAdornment: (
                    <InputAdornment position="end">
                      <IconButton
                        aria-label="toggle password confirmation visibility"
                        onClick={handleClickShowPasswordConfirm}
                        edge="end"
                      >
                        {showPasswordConfirm ? <VisibilityOff /> : <Visibility />}
                      </IconButton>
                    </InputAdornment>
                  )
                }}
              />
            </Grid>
          </Grid>

          <Typography variant="h6" gutterBottom className="section-title" sx={{ mt: 4 }}>
            利用児情報
          </Typography>

          <Grid container spacing={3}>
            <Grid item xs={12}>
              <TextField
                required
                fullWidth
                id="childName"
                name="childName"
                label="利用児氏名"
                placeholder="田中太郎"
                value={formValues.childName}
                onChange={handleChange}
                error={!!errors.childName}
                helperText={errors.childName}
              />
            </Grid>

            <Grid item xs={12}>
              <TextField
                required
                fullWidth
                id="childNameKana"
                name="childNameKana"
                label="利用児氏名（カナ）"
                placeholder="タナカタロウ"
                value={formValues.childNameKana}
                onChange={handleChange}
                error={!!errors.childNameKana}
                helperText={errors.childNameKana}
              />
            </Grid>

            <Grid item xs={12} sm={6}>
              <TextField
                required
                id="age"
                name="age"
                label="利用児年齢"
                type="number"
                placeholder="5"
                value={formValues.age}
                onChange={handleChange}
                error={!!errors.age}
                helperText={errors.age}
                inputProps={{ min: 0 }}
              />
            </Grid>

            <Grid item xs={12}>
              <FormControl component="fieldset">
                <FormLabel component="legend" required>性別</FormLabel>
                <RadioGroup
                  row
                  name="gender"
                  value={formValues.gender}
                  onChange={handleChange}
                >
                  <FormControlLabel value="男の子" control={<Radio />} label="男の子" />
                  <FormControlLabel value="女の子" control={<Radio />} label="女の子" />
                </RadioGroup>
              </FormControl>
            </Grid>

            <Grid item xs={12}>
              <TextField
                fullWidth
                id="diagnosis"
                name="diagnosis"
                label="診断名"
                placeholder="自閉症の疑い"
                value={formValues.diagnosis}
                onChange={handleChange}
              />
            </Grid>
          </Grid>

          <Typography variant="h6" gutterBottom className="section-title" sx={{ mt: 4 }}>
            住所情報
          </Typography>

          <Grid container spacing={3}>
            <Grid item xs={12} sm={6}>
              <TextField
                required
                id="postCode"
                name="postCode"
                label="郵便番号"
                placeholder="1234567"
                value={formValues.postCode}
                onChange={handleChange}
                error={!!errors.postCode}
                helperText={errors.postCode || "※ハイフンなしでご入力ください"}
                inputProps={{ maxLength: 7 }}
              />
            </Grid>

            <Grid item xs={12}>
              <TextField
                required
                fullWidth
                id="address"
                name="address"
                label="住所"
                placeholder="〇〇区"
                value={formValues.address}
                onChange={handleChange}
                error={!!errors.address}
                helperText={errors.address}
              />
            </Grid>
          </Grid>

          <Typography variant="h6" gutterBottom className="section-title" sx={{ mt: 4 }}>
            その他情報
          </Typography>

          <Grid container spacing={3}>
            <Grid item xs={12}>
              <FormControlLabel
                control={
                  <Checkbox
                    name="lineConsultation"
                    checked={formValues.lineConsultation}
                    onChange={handleChange}
                  />
                }
                label="LINE相談のみ"
              />
            </Grid>

            <Grid item xs={12}>
              <TextField
                fullWidth
                id="introduction"
                name="introduction"
                label="紹介先"
                placeholder="〇〇区役所"
                value={formValues.introduction}
                onChange={handleChange}
              />
            </Grid>

            <Grid item xs={12}>
              <TextField
                fullWidth
                id="consultation"
                name="consultation"
                label="相談内容"
                placeholder="言葉が出てこない。癇癪がすごい。"
                value={formValues.consultation}
                onChange={handleChange}
                multiline
                rows={5}
              />
            </Grid>
          </Grid>

          <Box mt={5} mb={2} textAlign="center">
            <Button
              type="submit"
              variant="contained"
              color="primary"
              size="large"
              className="submit-button"
              fullWidth
            >
              送信
            </Button>
          </Box>
        </Box>
      </Paper>
    </Container>
  );
};

export default Register;
