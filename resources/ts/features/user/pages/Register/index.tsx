import React, { useState } from 'react';

import { Model } from "survey-core";
import { Survey } from "survey-react-ui";
import "survey-core/survey-core.min.css";

import { userService } from "../../../../services/userService";

import Loading from "../../../../components/Loading";

import { json } from "./form_json";
import './style.module.css';

declare global {
  interface Window {
    csrfToken: string;
  }
}

// {
//   "tel": "11111111111",
//   "password": "11111111111",
//   "parentName": "親",
//   "parentNameKana": "オヤ",
//   "email": "tatataabcd@gmail.com",
//   "passwordConfirm": "11111111",
//   "postCode": "6180015",
//   "address": "大阪府三島郡",
//   "introduction": "区役所",
//   "consaltation": "癇癪",
//   "children": [
//      {
//         "childName": "子ども",
//         "childNameKana": "コドモ",
//         "childBirthDate": "2025-04-08",
//         "gender": "男の子",
//         "diagnosis": "a"
//      }
//   ]
// }

const Register = () => {
  const [isLoading, setIsLoading] = useState(false);

  const survey = new Model(json);
  survey.pagePrevText = "前へ";
  survey.completeText = "完了";

  var storageName = "survey_patient_history";
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
        saveSurveyData(sender)

        await userService.register(survey.data);
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

export default Register;
