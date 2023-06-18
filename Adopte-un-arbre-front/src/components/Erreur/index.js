import { Link } from 'react-router-dom';

import './styles.scss';

function Erreur() {
  return (
    <div className="erreur404">
      <div className="content">
        <h1>OUPS...ERREUR 404</h1>
        <p>Soyez différent !</p>
        <Link className="button" to="/projets">Je veux planter un arbre</Link>
      </div>
    </div>
  );
}

export default Erreur;
