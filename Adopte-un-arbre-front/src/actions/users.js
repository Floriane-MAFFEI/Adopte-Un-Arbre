export const UPDATE_INPUT = 'UPDATE_INPUT'; // pour les reducers users, projects et trees
export const CHECK_LOGIN = 'CHECK_LOGIN'; // pour le middleware usersMiddleware
export const SAVE_CONNECTED_USER = 'SAVE_CONNECTED_USER'; // pour le reducer users
export const SIGN_UP = 'SIGN_UP'; // pour le middleware usersMiddleware

export function actionUpdateInput(value, inputName) {
  return {
    type: UPDATE_INPUT,
    payload: {
      value: value,
      inputName: inputName,
    },
  };
}

export function actionCheckLogin() {
  return {
    type: CHECK_LOGIN,
  };
}

export function actionSignUp() {
  return {
    type: SIGN_UP,
  };
}
