import 'package:flutter/material.dart';
import 'package:mobile_aar_jiggen/alerte.dart';
import 'package:mobile_aar_jiggen/avis.dart';
import 'package:mobile_aar_jiggen/connection.dart';
import 'package:mobile_aar_jiggen/geolocation.dart';
import 'package:mobile_aar_jiggen/informations.dart';
import 'package:mobile_aar_jiggen/itineraire.dart';
import 'package:mobile_aar_jiggen/meritoire.dart';
import 'package:mobile_aar_jiggen/messages.dart';
import 'package:mobile_aar_jiggen/statistiques.dart';
import 'package:mobile_aar_jiggen/tracker.dart';
import 'package:mobile_aar_jiggen/video_recorder.dart';
import 'package:camera/camera.dart';
import 'api/call_api.dart';

class DrawerItem {
  String title;
  IconData icon;
  DrawerItem(this.title, this.icon);
}

class AccueilScreen extends StatefulWidget {
  final drawerItems = [
    new DrawerItem("Geolocation", Icons.location_on),
    new DrawerItem("Itinéraire", Icons.alt_route_rounded),
    new DrawerItem("Personne de confiance", Icons.person),
    new DrawerItem("Tracker", Icons.alt_route_rounded),
    new DrawerItem("Alerte", Icons.add_alert_rounded),
    new DrawerItem("Camera", Icons.photo_camera),
    new DrawerItem("Avis", Icons.rate_review),
    new DrawerItem("Statisques", Icons.assessment_rounded),
    new DrawerItem("Message", Icons.message),
    new DrawerItem("Informations personnelles", Icons.person_pin),
  ];

  @override
  State<StatefulWidget> createState() {
    return new AccueilScreenState();
  }
}

class AccueilScreenState extends State<AccueilScreen> {
  int _selectedDrawerIndex = 0;
  String _value = "";
  String _titre = "Message";
  String prenomData = decodedToken().toString();
  var user = getUser();

  _getDrawerItemWidget(int pos) {
    switch (pos) {
      case 0:
        return GeolocationFragment();
      case 1:
        return ItineraireFragment();
      case 2:
        return MeritoireFragment();
      case 3:
        return TrackerFragment();
      case 4:
        return AlerteFragment();
      case 5:
        return CameraScreenFragment();
      case 6:
        return AvisFragment();
      case 7:
        return StatistiquesFragment();
      case 8:
        return MessageFragment();
      case 9:
        return ProfilePage();
      /* case 10: 
        return new ChatbotFragment();*/
      default:
        return GeolocationFragment();
    }
  }

  handleClick(String value) {
    switch (value) {
      case 'Déconnexion':
        return deconnexion();
    }
  }

  _onSelectItem(int index) {
    setState(() => _selectedDrawerIndex = index);
    Navigator.of(context).pop();
  }

  deconnexion() {
    showAlertDialog(context);
  }

  @override
  Widget build(BuildContext context) {
    var drawerOptions = <Widget>[];
    for (var i = 0; i < widget.drawerItems.length; i++) {
      var d = widget.drawerItems[i];
      drawerOptions.add(new ListTile(
        leading: new Icon(d.icon),
        title: new Text(d.title),
        selected: i == _selectedDrawerIndex,
        onTap: () => _onSelectItem(i),
      ));
    }
    return new Scaffold(
      resizeToAvoidBottomInset: false,
      appBar: new AppBar(
        title: new Text("Aar Jiggen Gni"),
        actions: <Widget>[
          PopupMenuButton<String>(
            onSelected: handleClick,
            enabled: true,
            itemBuilder: (BuildContext context) {
              return {'Déconnexion'}.map((String choice) {
                return PopupMenuItem<String>(
                    value: choice, child: Text(choice));
              }).toList();
            },
          ),
        ],
      ),
      drawer: new Drawer(
          child: new SingleChildScrollView(
        child: new Column(
          children: <Widget>[
            new UserAccountsDrawerHeader(
              accountName: Text('Ndiaya Fall'),
              accountEmail: Text("ndiaya@gmail.com"),
              currentAccountPicture: CircleAvatar(
                backgroundColor: Colors.blueAccent,
                child: Text(
                  "A",
                  style: TextStyle(fontSize: 40.0),
                ),
              ),
            ),
            new Column(children: drawerOptions)
          ],
        ),
      )),
      body: _getDrawerItemWidget(_selectedDrawerIndex),
    );
  }
}

showAlertDialog(BuildContext context) {
  // set up the buttons
  Widget cancelButton = FlatButton(
    child: Text("Annuler"),
    onPressed: () {
      Navigator.of(context).pushAndRemoveUntil(
          MaterialPageRoute(builder: (context) => AccueilScreen()),
          (Route<dynamic> route) => false);
    },
  );
  Widget continueButton = FlatButton(
    child: Text("Continuer"),
    onPressed: () {
      Navigator.of(context).pushAndRemoveUntil(
          MaterialPageRoute(builder: (context) => LoginPage()),
          (Route<dynamic> route) => false);
    },
  );
  // set up the AlertDialog
  AlertDialog alert = AlertDialog(
    title: Text("Information"),
    content: Text("Etes-vous sûr de vouloir vous déconnectez?"),
    actions: [
      cancelButton,
      continueButton,
    ],
  );
  // show the dialog
  showDialog(
    context: context,
    builder: (BuildContext context) {
      return alert;
    },
  );
}
