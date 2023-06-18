import { Image } from 'semantic-ui-react';
import { Link } from 'react-router-dom';

import Footer from '../Footer';
import Header from '../Header';

import './styles.scss';

import chene from '../../assets/chene.png';
import hetre from '../../assets/hetre.jpeg';
import bouleau from '../../assets/bouleau.jpg';

function Accueil() {
  return (
    <>
      <Header />
      <div className="accueil">
        <h1>"Parce que la forêt a besoin de vous !"</h1>
      </div>
      <div className="demo">
        <h2>Notre projet</h2>
        <p>
          Adopte un arbre est une plateforme de parrainage d'arbres. Notre but est de connecter des personnes souhaitant contribuer à des projets de reforestation avec des organisations ou des initiatives locales. Vous avez la possibilité d'acheter un ou plusieurs arbres en finançant leur plantation et leur entretien. En retour, vous recevez des informations régulières sur la croissance et le développement de vos arbres et des projets déjà existants.
          Il y a énormément de cas de déforestation ces dernières années, c’est pourquoi il est important de sensibiliser à la santé de notre planète en contribuant à la reforestation, en ouvrant la possibilité d’avoir une communauté soudée, prête à participer financièrement ainsi que de s’investir dans le renouveau de notre planète.
        </p>
        <h2>Nos trois arbres préférés</h2>
        <div className="container">
          <div className="cards">
            <Image className="image-card" src={chene} wrapped ui={false} />
            <div className="name">
              <h3>Chêne</h3>
            </div>
            <div className="description">
              <p>Le chêne est l'arbre le plus répandu en France, avant le pin. Il représente 40 % des essences, feuillus et conifères confondus.</p>
            </div>
          </div>
          <div className="cards">
            <Image className="image-card" src={bouleau} wrapped ui={false} />
            <div className="name">
              <h3>Bouleau</h3>
            </div>
            <div className="description">
              <p>Les bouleaux poussent en général sur les terres pauvres et souvent siliceuses, jusqu'à 2000 m d'altitude.</p>
            </div>
          </div>
          <div className="cards">
            <Image className="image-card" src={hetre} wrapped ui={false} />
            <div className="name">
              <h3>Hêtre</h3>
            </div>
            <div className="description">
              <p>Le hêtre est un arbre à feuilles caduques, originaire d'Europe, de la famille des Fagacées qui comprend en outre le chêne et le châtaignier.</p>
            </div>
          </div>
        </div>
        <Link className="button" to="/participer">Voir plus d'arbres</Link>
      </div>
      <Footer />
    </>
  );
}

export default Accueil;
