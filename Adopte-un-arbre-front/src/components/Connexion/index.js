import { Form } from 'semantic-ui-react';
import './styles.scss';

import { useDispatch } from 'react-redux';

import Header from '../Header';
import Footer from '../Footer';
import InputControle from './InputControle';

import { actionCheckLogin } from '../../actions/users';

function Connexion() {
  const dispatch = useDispatch();

  const handleSubmit = async (event) => {
    event.preventDefault();
    dispatch(actionCheckLogin());
  };

  return (
    <>
      <Header />
      <h1 className="h1_connexion">Bienvenue sur votre espace de connexion</h1>
      <div className="connexion">
        <Form className="connexion_form" size="large" onSubmit={handleSubmit}>
          <Form.Field>
            <label>Email</label>
            <InputControle inputName="connexionEmail" placeholder="Email" type="email" />
          </Form.Field>
          <Form.Field>
            <label>Mot de passe</label>
            <InputControle inputName="connexionPassword" placeholder="Mot de passe" type="password" />
          </Form.Field>
          <button className="connexion_button" type="submit">
            Valider
          </button>
        </Form>
      </div>
      <Footer />
    </>
  );
}

export default Connexion;
