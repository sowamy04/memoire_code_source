import 'dart:convert';
import 'package:http/http.dart' as http;

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
    Uri.parse('http://192.168.1.5:8000/api/simple_users'),
    body: map,
  );
  print(response);
  return response;
}
