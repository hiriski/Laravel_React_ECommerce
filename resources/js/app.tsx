// import './bootstrap';

import ReactDOM from 'react-dom/client';
import { BrowserRouter } from 'react-router-dom';
import Component from './SampleComponent';

// styles
import '../css/index.scss';

ReactDOM.createRoot(document.getElementById('app')!).render(
  <BrowserRouter>
    <Component />
  </BrowserRouter>
);
