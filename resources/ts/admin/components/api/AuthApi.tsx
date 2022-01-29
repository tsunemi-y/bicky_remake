import axios from "axios";

const getUser = async () => {
  console.log('今からlaravelからユーザ取得します')
  const { data } = await axios.get('/api/admin/user');
  console.log(data);
  return data;
}

const login = async ({ email, password }) => {
  axios.get("/sanctum/csrf-cookie").then((response) => {
    const { data } = axios.post("/api/admin/login", {
        email,
        password,
      })
    return data
  })

  // await axios.get('/sanctum/csrf-cookie');
  // const { data } = await axios.post('/api/admin/login', { email, password });
  // console.log('AuthApi', data)
  // return data;
}

export {
  getUser,
  login
}