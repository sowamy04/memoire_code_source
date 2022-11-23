import 'dart:convert';
import 'dart:ffi';
import 'package:dio/dio.dart';
import 'package:http/http.dart' as http;
import 'package:jwt_decode/jwt_decode.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';

var apiUrl = "http://192.168.1.13:8000/api";
//var apiUrl = "http://127.0.0.1:8000/api";
final Dio _dio = Dio();
const FlutterSecureStorage storage = FlutterSecureStorage();
var _token = "";
//GlobalKey<MyState> _myKey = GlobalKey();

Future<String> login(String username, String password) async {
  var token = "";
  Response response = await _dio.post('$apiUrl/login_check',
      data: jsonEncode({'username': username, 'password': password}));
  token = response.data['token'];
  persistToken(token);
  var tokenData = getToken();
  var data = response.data;

  print("la response est $data");
  print("Token in localSorage : $tokenData");
  print(response.data['token']);
  return response.data['token'];
}

Future<void> persistToken(String token) async {
  await storage.write(key: "token", value: token);
}

/* Future getToken() async {
  await Future.sync(()  async =>  _token = await storage.read(key: 'token'));
 } */

Future<String?> getToken() async {
  return await storage.read(key: "token");
}

Future<void> deleteToken() async {
  ///await storage.delete(key: "token");
  await storage.deleteAll();
}

decodedToken() async {
  print('Avant décodage token');
  Map<String, String> allValues = await storage.readAll();
  _token = allValues['token'].toString();
  print('les valeurs $allValues');
  print('le token est : $_token');
  var payload = Jwt.parseJwt(_token);
  print('Le token décodé est :');
  print(payload['id']);
  return payload;
}

/* prenom() {
  var data = decodedToken();
  print("data $data");
  String prenom = data['prenom'].toString();
  return prenom;
} */

Future<http.Response> createUser(String prenom, String nom, String telephone,
    String email, String password, String genre, String adresse) {
  var map = new Map<String, dynamic>();
  map['prenom'] = prenom;
  map['nom'] = nom;
  map['telephone'] = telephone;
  map['email'] = email;
  map['password'] = password;
  map['adresse'] = adresse;
  map['genre'] = genre;
  print(map);
  final response = http.post(
    Uri.parse('$apiUrl/simple_users'),
    body: map,
  );
  print(response);
  return response;
}

Future<http.Response> getUser() async {
  Map<String, String> allValues = await storage.readAll();
  _token = allValues['token'].toString();
  var payload = Jwt.parseJwt(_token);
  print('tokenDAta : $payload');
  var id = payload['id'];

  print('id $id');
  final response = http.get(Uri.parse('$apiUrl/simple_users/$id'), headers: {
    'Authorization': 'Bearer $_token',
    'Content-Type': 'application/json'
  });
  print("response $response");
  print("Les informations de l'utilisateur sont : $response");
  //final data = jsonDecode(response.body);
  return response;
}

Future<List<Quartier>> getAllQuartiers() async {
  Map<String, String> allValues = await storage.readAll();
  _token = allValues['token'].toString();
  var payload = Jwt.parseJwt(_token);
  print('tokenDAta : $payload');
  var id = payload['id'];

  print('id $id');
  var response = http.get(Uri.parse('$apiUrl/quartiers'), headers: {
    'Authorization': 'Bearer $_token',
    'Content-Type': 'application/json'
  });
  print("response quartier $response");
  print("La liste des quartiers disponibles sont : $response");
  //final data = jsonDecode(response.body);
  //final parsed = json.decode(response.body).cast<Map<String, dynamic>>();
  var parsed = (json.decode(response.toString()) as List)
      .map((e) => Quartier.fromJson(e))
      .toList();
  String val = parsed.toString();
  print("La liste des quartiers disponibles après décodage sont : $val");
  return parsed;
}

Future<http.Response> addCoordonnees(double latitude, double longitude) async {
  print('ok');
  Map<String, String> allValues = await storage.readAll();
  _token = allValues['token'].toString();
  var payload = Jwt.parseJwt(_token);
  var id = payload['id'];
  final response = http.post(
    Uri.parse('$apiUrl/coordonnees_geographiques'),
    body: jsonEncode(
        <String, double>{'lattitude': latitude, 'longitude': longitude}),
    headers: {
      'Authorization': 'Bearer $_token',
      'Content-Type': 'application/json'
    },
  );
  print("response $response");
  //final data = jsonDecode(response.body);
  return response;
}

Future<http.Response> addItineraire(
    String depart,
    String arrivee,
    double latDepart,
    double longDepart,
    double latArrivee,
    double longArrivee) async {
  print('ok');
  Map<String, String> allValues = await storage.readAll();
  _token = allValues['token'].toString();
  var payload = Jwt.parseJwt(_token);
  var id = payload['id'];
  final response = http.post(
    Uri.parse('$apiUrl/itineraires'),
    body: jsonEncode({
      'depart': depart,
      'arrivee': arrivee,
      'latDepart': latArrivee,
      'longDepart': longDepart,
      'latArrivee': latArrivee,
      'longArrivee': longArrivee
    }),
    headers: {
      'Authorization': 'Bearer $_token',
      'Content-Type': 'application/json'
    },
  );
  print("response $response");
  //final data = jsonDecode(response.body);
  return response;
}

Future<http.Response> chooseMeritoire(
    String nomComplet, String telephone) async {
  print('ok');
  Map<String, String> allValues = await storage.readAll();
  _token = allValues['token'].toString();
  var payload = Jwt.parseJwt(_token);
  var id = payload['id'];
  final response = http.post(
    Uri.parse('$apiUrl/personne_confiances'),
    body: jsonEncode(
        <String, String>{'nomComplet': nomComplet, 'telephone': telephone}),
    headers: {
      'Authorization': 'Bearer $_token',
      'Content-Type': 'application/json'
    },
  );
  print("response $response");
  //final data = jsonDecode(response.body);
  return response;
}

Future<http.Response> ajouterAvis(
    String eclairagePublique,
    String vol,
    String viol,
    String agression,
    String transport,
    String description,
    String qualiteRoute) async {
  print('ok');
  Map<String, String> allValues = await storage.readAll();
  _token = allValues['token'].toString();
  var payload = Jwt.parseJwt(_token);
  var id = payload['id'];
  final response = http.post(
    Uri.parse('$apiUrl/avis'),
    body: jsonEncode(<String, String>{
      'eclairage': eclairagePublique,
      'vol': vol,
      'viol': viol,
      'agression': agression,
      'transport': transport,
      'description': description,
      'qualiteRoute': qualiteRoute,
      'quartiers': "1"
    }),
    headers: {
      'Authorization': 'Bearer $_token',
      'Content-Type': 'application/json'
    },
  );
  print("response $response");
  //final data = jsonDecode(response.body);
  return response;
}

/* Future<String> createUser(String prenom, String nom, String telephone,
    String email, String password, String genre, String adresse) async {
  var map = Map<String, dynamic>();
  map['prenom'] = prenom;
  map['nom'] = nom;
  map['telephone'] = telephone;
  map['email'] = email;
  map['password'] = password;
  map['adresse'] = adresse;
  map['genre'] = genre;
  Response response = await _dio.post(
    '$apiUrl/simple_users',
    data: map,
  );
  return response.data;
} */

class Quartier {
  int id;
  String nomQuartier;

  Quartier({required this.id, required this.nomQuartier});

  factory Quartier.fromJson(Map<String, dynamic> json) {
    return Quartier(id: json['id'], nomQuartier: json['nomQuartier']);
  }
}

/* Widget _buildPrenom() {
   return FutureBuilder<String>(
        future:  getDatas(),
        builder: (context, snapshot) {
          if (snapshot.hasData) {
            return TextFormField(

              initialValue: snapshot.data,
              decoration: InputDecoration(
                labelText: 'Prenom',
                border: OutlineInputBorder(),
                focusedBorder: OutlineInputBorder(
                    borderSide: BorderSide(color: Color(0xffDEA900))),
,
              ),
              validator: (String value) {
                if (value.isEmpty) {
                  return 'Le prenom est obligatoire';
                }

                return null;
              },
              onSaved: (String value) {
                _prenom = value;
              },
            );
            
          } 
          return Text("eeeeeeee");
        } */
