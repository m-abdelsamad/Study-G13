const firebaseConfig = {
    apiKey: "AIzaSyBZ7h2wKmFQURt3WPCjSKnPGg28a0kagYA",
    authDomain: "chatapp-js-87219.firebaseapp.com",
    databaseURL: "https://chatapp-js-87219-default-rtdb.firebaseio.com",
    projectId: "chatapp-js-87219",
    storageBucket: "chatapp-js-87219.appspot.com",
    messagingSenderId: "863140213077",
    appId: "1:863140213077:web:5cb9ae6d649f79e597bfdc"
};
const firebaseApp = firebase.initializeApp(firebaseConfig);
const db = firebaseApp.firestore(); 

const usersCollection = db.collection('users');
const chatsCollection =  db.collection('chats');
