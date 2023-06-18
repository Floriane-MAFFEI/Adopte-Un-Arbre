import './styles.scss';
import { Input } from 'semantic-ui-react';

import { Link } from 'react-router-dom';

import { useState } from 'react';
import { useSelector } from 'react-redux';

import Footer from '../Footer';
import Header from '../Header';

import adopt from '../../assets/adopt.jpg';
import sol from '../../assets/sol.png';
import foret from '../../assets/foret.png';
import envoi from '../../assets/envoi.png';

function ProfilOrganisme() {
  const [previewImage, setPreviewImage] = useState(adopt);
  const [previewImage1, setPreviewImage1] = useState(adopt);
  const [previewImage2, setPreviewImage2] = useState(adopt);
  const projects = useSelector((state) => state.projects.list);

  const selectFile = (event) => {
    setPreviewImage(URL.createObjectURL(event.target.files[0]));
  };

  const selectFile1 = (event) => {
    setPreviewImage1(URL.createObjectURL(event.target.files[0]));
  };

  const selectFile2 = (event) => {
    setPreviewImage2(URL.createObjectURL(event.target.files[0]));
  };

  const isAuth = localStorage.getItem('token');

  if (isAuth) {
    return (
      <>
        <Header />
        <main className="main_profilOrganisme">
          <section className="profil_profilOrganisme">
            <div>
              <div className="cadre_profilOrganisme">
                <img className="avatar_profilOrganisme" src={previewImage} alt="avatar" />
              </div>
              <Input onChange={selectFile} size="small" type="file" />
            </div>
            <div className="infos_profilOrganisme">
              <h3 className="h3_profilOrganisme">Bienvenue chez ... !</h3>
              <p className="description_profilOrganisme">Shortbread fruitcake chocolate bar fruitcake topping sweet sugar plum. Soufflé croissant topping jelly muffin. Wafer gingerbread gummi bears halvah marzipan cookie biscuit icing. Icing cookie topping muffin chocolate bar candy canes wafer jujubes. Macaroon apple pie pudding wafer ice cream candy donut. Jujubes gummi bears biscuit croissant tiramisu candy cookie. Marshmallow chocolate pastry chocolate cake carrot cake danish croissant. Pastry sugar plum sweet roll pastry tiramisu sweet. Toffee chocolate muffin pie gummies jelly-o jelly beans pudding sesame snaps. Ice cream oat cake gummies lemon drops marshmallow. Fruitcake toffee cake shortbread pudding pastry. Gingerbread cake lemon drops cheesecake bear claw chocolate halvah tiramisu gummi bears. Biscuit chocolate cake cake toffee ice cream. Chocolate halvah macaroon chupa chups candy canes gingerbread gingerbread.</p>
            </div>
          </section>
          <div className="donnees_profilOrganisme">
            <div className="comptes_profilOrganisme">
              <img className="logo_profilOrganisme" src={sol} alt="plantation" />
              <p className="p_profilOrganisme">... projets en cours</p>
            </div>
            <div className="comptes_profilOrganisme">
              <img className="logo_profilOrganisme" src={foret} alt="arbres" />
              <p className="p_profilOrganisme">... projets terminés</p>
            </div>
          </div>
          <section className="new_profilOrganisme">
            <Link className="button_profilOrganisme" to="/creer_un_projet">Proposer un nouveau projet</Link>
            <div className="news_profilOrganisme">
              <img className="logoEnvoi_profilOrganisme" src={envoi} alt="flêche" />
              <p className="pEnvoi_profilOrganisme">Donner des nouvelles:</p>
            </div>
            <p className="pPhotos_profilOrganisme">En ajoutant fréquemment des photos de vos arbres, vous encouragez les parrains potentiels à financer les projets en cours. Proposez, par exemple, des photos de vos arbres en fleurs ou lors des récoltes de fruits.</p>
            <div className="photos_profilOrganisme">
              <div className="photo_profilOrganisme">
                <div className="cadres_profilOrganisme">
                  <img className="image_profilOrganisme" src={previewImage1} alt="arbre" />
                </div>
                <form>
                  <input onChange={selectFile1} className="fileInput_profilOrganisme" type="file" />
                  <select className="select_profilOrganisme">
                    <option>-- Projet --</option>
                    {
                  projects.map((project) => <option value={project.id}>{project.name}</option>)
                  }
                  </select>
                  <button className="fileButton_profilOrganisme" type="submit">valider</button>
                </form>
              </div>
              <div className="photo_profilOrganisme">
                <div className="cadres_profilOrganisme">
                  <img className="image_profilOrganisme" src={previewImage2} alt="arbre" />
                </div>
                <form>
                  <input onChange={selectFile2} className="fileInput_profilOrganisme" type="file" />
                  <select className="select_profilOrganisme">
                    <option>-- Projet --</option>
                    {
                  projects.map((project) => <option value={project.id}>{project.name}</option>)
                  }
                  </select>
                  <button className="fileButton_profilOrganisme" type="submit">valider</button>
                </form>
              </div>
            </div>
          </section>
        </main>
        <Footer />
      </>
    );
  }
  window.location = '/';
}

export default ProfilOrganisme;
