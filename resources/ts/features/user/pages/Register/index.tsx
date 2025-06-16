import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';

import { Model } from "survey-core";
import { Survey } from "survey-react-ui";
import "survey-core/survey-core.min.css";

import { userService } from "../../../../services/userService";
import useAuthGuard from '../../services/useAuthGuard';

import Loading from "../../../../components/Loading";

import { json } from "./form_json";
import './style.module.css';

import { Snackbar, Alert } from "@mui/material";

declare global {
  interface Window {
    csrfToken: string;
  }
}

const Register = () => {
  const navigate = useNavigate();
  const isAuthed = useAuthGuard();
  
  useEffect(() => {
    if (isAuthed) {
      navigate("/reservation");
    }
  }, [isAuthed, navigate]);

  const [isLoading, setIsLoading] = useState(false);
  const [snackbarOpen, setSnackbarOpen] = useState(false);
  const [snackbarMessage, setSnackbarMessage] = useState("");
  const [snackbarSeverity, setSnackbarSeverity] = useState<"success" | "info" | "warning" | "error">("error");

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

        navigate('/reservation', { state: { snackbar: { message: '新規登録に成功しました', severity: 'success' } } });
      } catch (error) {
        let message = "新規登録に失敗しました";
        if (error instanceof Error) {
          message = error.message;
        } else if (typeof error === "string") {
          message = error;
        }
        setSnackbarMessage(message);
        setSnackbarSeverity("error");
        setSnackbarOpen(true);
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

  const handleSnackbarClose = (
    event?: React.SyntheticEvent | Event,
    reason?: string
  ) => {
    if (reason === 'clickaway') {
      return;
    }
    setSnackbarOpen(false);
  };

  return (
    <>
      <Survey model={survey} />
      <Loading is_loading={isLoading} />
      <Snackbar
        open={snackbarOpen}
        autoHideDuration={6000}
        onClose={handleSnackbarClose}
        anchorOrigin={{ vertical: 'top', horizontal: 'center' }}
      >
        <Alert onClose={handleSnackbarClose} severity={snackbarSeverity} sx={{ width: '100%' }}>
          {snackbarMessage}
        </Alert>
      </Snackbar>
    </>
  );
};

export default Register;
