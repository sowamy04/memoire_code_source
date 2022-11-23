import 'package:flutter/material.dart';
import 'package:front_mobile_aar_jiggen/alerte.dart';
import 'package:front_mobile_aar_jiggen/avis.dart';
import 'package:front_mobile_aar_jiggen/chatbot.dart';
import 'package:front_mobile_aar_jiggen/geofence.dart';
import 'package:front_mobile_aar_jiggen/geolocation.dart';
import 'package:front_mobile_aar_jiggen/informations.dart';
import 'package:front_mobile_aar_jiggen/itineraire.dart';
import 'package:front_mobile_aar_jiggen/meritoire.dart';
import 'package:front_mobile_aar_jiggen/messages.dart';
import 'package:front_mobile_aar_jiggen/statistiques.dart';
import 'package:front_mobile_aar_jiggen/tracker.dart';
import 'package:front_mobile_aar_jiggen/video_recorder.dart';

import 'package:camera/camera.dart';

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
    new DrawerItem("Chatbot", Icons.chat),
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

  _getDrawerItemWidget(int pos) {
    switch (pos) {
      case 0:
        return new GeolocationFragment();
      case 1:
        return new ItineraireFragment();
      case 2:
        return new TrackerFragment();
      case 3:
        return new TrackerFragment();
      case 4:
        return new AlerteFragment();
      case 5:
        return new CameraScreenFragment();
      case 6:
        return new AvisFragment();
      case 7:
        return new StatistiquesFragment();
      case 8:
        return new MessageFragment();
      case 9:
        return new ChatbotFragment();
      case 10:
        return new ProfilePage();
      default:
        return new GeolocationFragment();
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

  deconnexion() {}

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
        child: new Column(
          children: <Widget>[
            new UserAccountsDrawerHeader(
              accountName: new Text("Amy SOW"),
              accountEmail: new Text("amysow04@gmail.com"),
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
      ),
      body: _getDrawerItemWidget(_selectedDrawerIndex),
    );
  }
}
