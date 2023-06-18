import './styles.scss';
import { Form } from 'semantic-ui-react';

import { useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';

import adopt from '../../assets/adopt.jpg';

import { actionCreateTrees } from '../../actions/trees';
import { actionUpdateInput } from '../../actions/users';

import Header from '../Header';
import Footer from '../Footer';
import InputControleArbres from './InputControleArbres';

function CreerProjet() {
  const [previewImage, setPreviewImage] = useState(adopt);
  const species = useSelector((state) => state.trees.speciesList);

  const dispatch = useDispatch();

  const handleCreateTrees = (event) => {
    event.preventDefault();
    dispatch(actionCreateTrees());
  };

  const handleSelectChange = (event) => {
    dispatch(actionUpdateInput(event.target.value, 'treeSpecie'));
  };

  const handleInputChange = (event) => {
    dispatch(actionUpdateInput(event.target.value, 'treeDescription'));
  };

  const selectFile = (event) => {
    setPreviewImage(URL.createObjectURL(event.target.files[0]));
  };

  const isAuth = localStorage.getItem('token');

  if (isAuth) {
    return (
      <>
        <Header />
        <main className="main_creerArbres">
          <h3>Créez vos arbres: </h3>
          <div className="cadre_creerArbres">
            <img className="img_creerArbres" src={previewImage} alt="l'arbre" />
          </div>
          <Form className="form_creerArbres" size="large" onSubmit={handleCreateTrees}>
            <Form.Field>
              <InputControleArbres onChange={selectFile} inputName="treeImage" type="file" required />
            </Form.Field>
            <select onChange={handleSelectChange}>
              <option>-- Espèce --</option>
              {
              species.map((specie) => <option value={specie.name}>{specie.name}</option>)
              }
            </select>
            <Form.Group>
              <Form.Field>
                <label>Code postal</label>
                <InputControleArbres inputName="treeZipCode" placeholder="Code postal" type="number" required />
              </Form.Field>
              <Form.Field>
                <label>Ville</label>
                <InputControleArbres inputName="treeCity" placeholder="Ville" type="text" required />
              </Form.Field>
            </Form.Group>
            <Form.Field>
              <label>Prix de l'arbre (en euros)</label>
              <InputControleArbres inputName="treePrice" placeholder="prix" type="number" required />
            </Form.Field>
            <Form.TextArea onChange={handleInputChange} label="Description" placeholder="Description de l'arbre" required />
            <Form.Field>
              <label>Nombre d'arbres identiques à ajouter</label>
              <InputControleArbres inputName="treeNumber" placeholder="Total" type="number" required />
            </Form.Field>
            <button className="connexion_button" type="submit">
              Valider
            </button>
          </Form>
        </main>
        <Footer />
      </>
    );
  }
  window.location = '/';
}

export default CreerProjet;
