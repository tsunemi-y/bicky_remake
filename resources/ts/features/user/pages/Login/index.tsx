import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';

import { Model } from "survey-core";
import { Survey } from "survey-react-ui";
import "survey-core/survey-core.min.css";

import { userService } from "../../../../services/userService";

import Loading from "../../../../components/Loading";

import { json } from "./form_json";
import './styles.module.css';

declare global {
  interface Window {
    csrfToken: string;
  }
}

const Login = () => {
  const [isLoading, setIsLoading] = useState(false);
  const navigate = useNavigate();

  const survey = new Model(json);
  survey.pagePrevText = "前へ";
  survey.completeText = "ログイン";

  // ローカルストレージ名（ログインは基本不要だが、Registerに合わせて一応用意）
  var storageName = "survey_login";
  function saveSurveyData(survey: Model) {
      var data = survey.data;
      data.pageNo = survey.currentPageNo;
      window.localStorage.setItem(storageName, JSON.stringify(data));
  }
  survey.onPartialSend.add(function(sender){
      saveSurveyData(sender);
  });

  survey.onComplete.add(async function(sender, options){
      setIsLoading(true);

      try {
        saveSurveyData(sender);

        // ログインAPI呼び出し
        await userService.login(survey.data);

        navigate('/reservation', { state: { snackbar: { message: 'ログインに成功しました', severity: 'success' } } });
      } catch (error) {
        alert(error);
      } finally {
        setIsLoading(false);
      }
  });

  survey.partialSendEnabled = true;
  var prevData = window.localStorage.getItem(storageName) || null;
  if(prevData) {
      var data = JSON.parse(prevData);
      survey.data = data;
      if(data.pageNo) {
          survey.currentPageNo = data.pageNo;
      }
  }

  return (
    <>
      <Survey model={survey} />
      <Loading is_loading={isLoading} />
    </>
  );
};

export default Login;
