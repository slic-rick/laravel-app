import './bootstrap';
import Search from './live-search';
import Chat from './chat';

import Profile from './profile';

if (document.querySelector('.header-search-icon')) {
    new Search();
}

if (document.querySelector('.profile-nav')) {
    // alert('INiyt')
    new Profile();
}

if (document.querySelector('.header-chat-icon')) {
    //alert('Chat')
    new Chat();
}
