import './styles.scss';
import { Form } from 'semantic-ui-react';

import { useDispatch } from 'react-redux';

import Header from '../Header';
import Footer from '../Footer';
import InputControleInscription from './InputControleInscription';

import { actionSignUp } from '../../actions/users';

import hetre from '../../assets/hetre.jpeg';
import chene from '../../assets/chene.png';

function Inscription() {
  const dispatch = useDispatch();

  const handleSubmit = (event) => {
    event.preventDefault();
    dispatch(actionSignUp());
  };

  return (
    <>
      <Header />
      <main className="main_inscription">
        <section className="image1">
          <img className="main_img" src={hetre} alt="hêtre" />
        </section>
        <section>
          <h1 className="h1_inscription">Rejoignez-nous :</h1>
          <div className="inscription">
            <Form className="inscription_form" size="large" onSubmit={handleSubmit}>
              <Form.Field>
                <label>Nom</label>
                <InputControleInscription inputName="inscriptionLastName" placeholder="Nom" type="text" required />
              </Form.Field>
              <Form.Field>
                <label>Prénom</label>
                <InputControleInscription inputName="inscriptionFirstName" placeholder="Prénom" type="text" required />
              </Form.Field>
              <Form.Field>
                <label>Email</label>
                <InputControleInscription inputName="inscriptionEmail" placeholder="Email" type="email" required />
              </Form.Field>
              <Form.Field>
                <label>Adresse</label>
                <InputControleInscription inputName="inscriptionAdress" placeholder="Adresse" type="text" required />
              </Form.Field>
              <Form.Group>
                <Form.Field>
                  <label>Code postal</label>
                  <InputControleInscription inputName="inscriptionZipCode" placeholder="Code postal" type="number" required />
                </Form.Field>
                <Form.Field>
                  <label>Ville</label>
                  <InputControleInscription inputName="inscriptionCity" placeholder="Ville" type="text" required />
                </Form.Field>
              </Form.Group>
              <Form.Field>
                <label>Date de naissance</label>
                <InputControleInscription inputName="inscriptionBirthDate" placeholder="Date de naissance" type="date" required />
              </Form.Field>
              <Form.Field>
                <label>Mot de passe</label>
                <InputControleInscription inputName="inscriptionPassword" placeholder="Mot de passe" type="password" required />
              </Form.Field>
              <button className="connexion_button" type="submit">
                Valider
              </button>
            </Form>
          </div>
        </section>
        <section className="image2">
          <img className="main_img" src={hetre} alt="hêtre" />
          <img className="main_img" src={chene} alt="hêtre" />
        </section>
      </main>
      <Footer />
    </>
  );
}

export default Inscription;
