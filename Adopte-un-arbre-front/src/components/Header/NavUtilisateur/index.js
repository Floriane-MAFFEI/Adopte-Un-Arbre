import '../styles.scss';
import { Link } from 'react-router-dom';
import axios from 'axios';

function NavUtilisateur() {
  function handleDeconnexion() {
    localStorage.removeItem('token');

    axios.defaults.headers.common.Authorization = null;
  }

  const user = JSON.parse(localStorage.getItem('user'));

  const firstName = user.firstname;

  return (
    <nav>
      <Link className="link" to="/">Accueil</Link>
      <Link className="link" to={`/profil/${firstName}`}>Mon profil</Link>
      <Link className="link" to="/projets">Projets</Link>
      <Link className="link" to="/greenteam">Green Team</Link>
      <a onClick={handleDeconnexion} className="link" href="/">Déconnexion</a>
    </nav>
  );
}

export default NavUtilisateur;
