import React, {useContext, createContext, useState, ReactNode} from "react"

const AuthContext = createContext({
  isAuth: false,
  setIsAuth: () => {}
})

export const AuthProvider: React.VFC<{ children: ReactNode }> = ({ children }) => {
  const [isAuth, setIsAuth] = useState<boolean>(false);

  return (
    <AuthContext.Provider value={{ isAuth, setIsAuth }}>
      { children }
    </AuthContext.Provider>
  )
}

export const useAuth = () => useContext(AuthContext);