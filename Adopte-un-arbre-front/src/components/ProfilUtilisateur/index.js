import { Input } from 'semantic-ui-react';
import './styles.scss';

import { useState } from 'react';
import { Link } from 'react-router-dom';

import Footer from '../Footer';
import Header from '../Header';

import adopt from '../../assets/adopt.jpg';
import foret from '../../assets/forest.png';
import feuille from '../../assets/leaf.png';
import envoi from '../../assets/envoi.png';

function ProfilUtilisateur() {
  const [previewImage, setPreviewImage] = useState(adopt);

  const user = JSON.parse(localStorage.getItem('user'));

  console.log(user);

  const selectFile = (event) => {
    setPreviewImage(URL.createObjectURL(event.target.files[0]));
  };

  const isAuth = localStorage.getItem('token');

  if (isAuth) {
    return (
      <>
        <Header />
        <main className="main_profilUtilisateur">
          <section className="profil_profilUtilisateur">
            <div>
              <div className="cadre_profilUtilisateur">
                {
                  user.avatar ? (<img className="avatar_profilUtilisateur" src={user.avatar} alt="avatar" />) : (<img className="avatar_profilUtilisateur" src={previewImage} alt="avatar" />)
                }
              </div>
              <Input onChange={selectFile} type="file" size="mini" />
            </div>
            <div className="infos_profilUtilisateur">
              <h3 className="h3_profilUtilisateur">Bienvenue sur votre profil {user.firstname} !</h3>
              <div className="comptes_profilUtilisateur">
                <img className="logo_profilUtilisateur" src={feuille} alt="renouvellement" />
                {
                  user.trees === 0 ? (<p className="p_profilUtilisateur">pas de projets encouragés</p>) : (<p className="p_profilUtilisateur">... projets encouragés</p>)
                }
              </div>
              <div className="comptes_profilUtilisateur">
                <img className="logo_profilUtilisateur" src={foret} alt="arbres" />
                {
                  user.trees.length === 0 ? (<p className="p_profilUtilisateur">Pas d'arbres parrainés</p>) : (<p className="p_profilUtilisateur">{user.trees.length} arbres parrainés</p>)

                }
              </div>
            </div>
          </section>
          {
            user.trees.length === 0 ? (
              <section className="arbres_profilUtilisateur">
                <h3>Vous n'avez pas encore d'arbres parrainés</h3>
                <div className="adopter_profilUtilisateur">
                  <img className="logoEnvoi_profilUtilisateur" src={envoi} alt="flêche" />
                  <p className="pEnvoi_profilUtilisateur">Aller voir les projets:</p>
                </div>
                <p className="p2_profilUtilisateur">En allant voir nos projets et en parrainant un arbre, vous donnez l'oppportunité à nos organisme de donner un second souffle à notre planète !</p>
                <Link className="button_profilUtilisateur" to="/projets">Projets</Link>
              </section>
            )
              : (
                <section className="arbres_profilUtilisateur">
                  <h3>Vos arbres: </h3>
                  <div className="cards_profilUtilisateur">
                    {user.trees.map((tree) => (
                      <div className="container_profilUtilisateur">
                        <div className="photo_profilUtilisateur">
                          <div className="cadres_profilUtilisateur">
                            <img className="image_profilUtilisateur" src={adopt} alt="arbre" />
                          </div>
                          <p>{tree.specie.name} ({tree.specie.scientific_name})</p>
                          <p>originaire d'{tree.origin}</p>
                          <div className="desc_profilUtilisateur">
                            <p className="treeDescription_profilUtilisateur">{tree.specie.description}</p>
                          </div>
                        </div>
                      </div>
                    ))}
                  </div>
                </section>
              )
          }
        </main>
        <Footer />
      </>
    );
  }
  window.location = '/';
}

export default ProfilUtilisateur;
