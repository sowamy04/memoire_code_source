import 'dart:async';
import 'package:jwt_decode/jwt_decode.dart';
import 'package:flutter/material.dart';
import 'package:mobile_aar_jiggen/connection.dart';
import 'package:mobile_aar_jiggen/homePage.dart';
import 'api/call_api.dart';
import 'package:camera/camera.dart';

List<CameraDescription> cameras = [];

Future<void> main() async {
  try {
    WidgetsFlutterBinding.ensureInitialized();
    cameras = await availableCameras();
  } on CameraException catch (e) {
    print('Error in fetching the cameras: $e');
  }
  runApp(new MaterialApp(
    home: new SplashScreen(),
    debugShowCheckedModeBanner: false,
    routes: <String, WidgetBuilder>{
      '/HomeScreen': (BuildContext context) => new LoginPage()
    },
  ));
}

/* void main() {
  runApp(new MaterialApp(
    home: new SplashScreen(),
    debugShowCheckedModeBanner: false,
    routes: <String, WidgetBuilder>{
      '/HomeScreen': (BuildContext context) => new LoginScreen()
    },
  ));
} */

class SplashScreen extends StatefulWidget {
  @override
  _SplashScreenState createState() => new _SplashScreenState();
}

class _SplashScreenState extends State<SplashScreen> {
  String _token = "";
  startTime() async {
    var _duration = new Duration(seconds: 5);
    //return Timer(_duration, navigationPage);
    return tokenContent(_duration);
  }

  tokenContent(duree) async {
    Map<String, String> allValues = await storage.readAll();
    _token = allValues['token'].toString();
    print('token $_token');
    var payload = Jwt.parseJwt(_token);
    print(payload['id']);
    if (payload['id'] != null) {
      return Timer(duree, existToken);
    }
    return Timer(duree, navigationPage);
  }

  void navigationPage() {
    Navigator.of(context).pushReplacementNamed('/HomeScreen');
  }

  void existToken() {
    Navigator.of(context).pushAndRemoveUntil(
        MaterialPageRoute(builder: (context) => AccueilScreen()),
        (Route<dynamic> route) => false);
  }

  @override
  void initState() {
    super.initState();
    startTime();
  }

  @override
  Widget build(BuildContext context) {
    return new Scaffold(
      backgroundColor: Colors.white,
      body: new Center(
        child: new Container(
          child: new Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: <Widget>[
              new Image.asset(
                'assets/images/logo.png',
                width: 400,
                height: 400,
              ),
              /* new Text(
                "",
              ), */
              /* new Text(
              "Aar Sunu Jigueen Gni, Moy Aar Société Bi",
              style:
              new TextStyle(color: Colors.blue, fontSize: 20.0),
            ), */
              /* new Container(
                padding: EdgeInsets.fromLTRB(0, 80, 0, 0),
                child: new CircularProgressIndicator(
                  backgroundColor: Colors.white,
                ),
              ), */
            ],
          ),
        ),
      ),
    );
  }
}
