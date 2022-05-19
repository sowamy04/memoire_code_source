import 'package:flutter/material.dart';
import 'package:front_mobile_aar_jiggen/geofence.dart';
import 'package:front_mobile_aar_jiggen/geolocation.dart';

class AlerteFragment extends StatefulWidget {
  @override
  _AlerteFragmentState createState() => _AlerteFragmentState();
}

class _AlerteFragmentState extends State<AlerteFragment> {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      home: Scaffold(
          body: Center(
              child: Column(children: <Widget>[
        Container(
          margin: EdgeInsets.all(25),
          child: FlatButton(
            child: Text(
              'Lancer une alerte',
              style: TextStyle(fontSize: 20.0),
            ),
            color: Colors.blue,
            textColor: Colors.black,
            onPressed: () {
              Geofence();
            },
          ),
        ),
      ]))),
    );
  }
}

showAlertDialog(BuildContext context) {
  // set up the button
  Widget okButton = TextButton(
    child: Text("OK"),
    onPressed: () {
      Navigator.push(
        context,
        MaterialPageRoute(builder: (context) => GeolocationFragment()),
      );
    },
  );

  // set up the AlertDialog
  AlertDialog alert = AlertDialog(
    title: Text("Alerte"),
    content: Text("Alerte transmis avec succès!"),
    actions: [
      okButton,
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
