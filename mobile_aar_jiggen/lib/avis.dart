import 'package:flutter/material.dart';
import 'package:mobile_aar_jiggen/theme.dart';
import 'package:mobile_aar_jiggen/header.dart';
import 'api/call_api.dart';
import 'package:mobile_aar_jiggen/informations.dart';

class AvisFragment extends StatefulWidget {
  @override
  _AvisFragmentState createState() => _AvisFragmentState();
}

class _AvisFragmentState extends State<AvisFragment> {
  final _formKey = GlobalKey<FormState>();
  final String _message = "Avis ajouté avec succès, merci!";

  /* FutureBuilder<List<Quartier>>(
        future: getAllQuartiers(),
        builder: (context, snapshot) {
          print(snapshot.data);
          return Text("eeeeeeee");
        }); */

  var quartiers = getAllQuartiers();

  TextEditingController volController = TextEditingController();
  TextEditingController violController = TextEditingController();
  TextEditingController agressionController = TextEditingController();
  TextEditingController transportController = TextEditingController();
  TextEditingController quartierController = TextEditingController();
  TextEditingController descriptionController = TextEditingController();
  TextEditingController eclairageController = TextEditingController();
  TextEditingController qualiteController = TextEditingController();

  get index => null;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      body: SingleChildScrollView(
        child: Stack(
          children: [
            /* Container(
              height: 150,
              child: HeaderWidget(150, false, Icons.person_add_alt_1_rounded),
            ), */
            Container(
              margin: EdgeInsets.fromLTRB(25, 50, 25, 10),
              padding: EdgeInsets.fromLTRB(10, 0, 10, 0),
              alignment: Alignment.center,
              child: Column(
                children: [
                  Form(
                    key: _formKey,
                    child: Column(
                      children: [
                        GestureDetector(
                          child: Stack(
                            children: [
                              Container(
                                padding: EdgeInsets.all(10),
                                decoration: BoxDecoration(
                                  /* borderRadius: BorderRadius.circular(100), */
                                  border:
                                      Border.all(width: 5, color: Colors.white),
                                  color: Colors.white,
                                  boxShadow: [
                                    BoxShadow(
                                      color: Colors.black12,
                                      blurRadius: 20,
                                      offset: const Offset(5, 5),
                                    ),
                                  ],
                                ),
                                child: new Image.asset('assets/images/avis.png',
                                    height: 100, width: 200),
                                /* Icon(
                                  Icons.person,
                                  color: Colors.grey.shade300,
                                  size: 80.0,
                                ), */
                              ),
                              /* Container(
                                padding: EdgeInsets.fromLTRB(80, 80, 0, 0),
                                child: Icon(
                                  Icons.add_circle,
                                  color: Colors.grey.shade700,
                                  size: 25.0,
                                ),
                              ), */
                            ],
                          ),
                        ),
                        SizedBox(
                          height: 30,
                        ),
                        Container(
                          child: TextFormField(
                              controller: volController,
                              decoration: ThemeHelper().textInputDecoration(
                                  'Vol',
                                  'Donnez une note pour le vol entre 0 et 5'),
                              keyboardType: TextInputType.number),
                          decoration: ThemeHelper().inputBoxDecorationShaddow(),
                        ),
                        SizedBox(
                          height: 30,
                        ),
                        Container(
                          child: TextFormField(
                            controller: violController,
                            decoration: ThemeHelper().textInputDecoration(
                                'Viol',
                                'Donnez une note pour le viol entre 0 et 5'),
                            keyboardType: TextInputType.number,
                          ),
                          decoration: ThemeHelper().inputBoxDecorationShaddow(),
                        ),
                        SizedBox(height: 20.0),
                        Container(
                          child: TextFormField(
                              controller: agressionController,
                              decoration: ThemeHelper().textInputDecoration(
                                  'Agression',
                                  'Donnez une note pour l\'agression entre 0 et 5'),
                              keyboardType: TextInputType.number),
                          decoration: ThemeHelper().inputBoxDecorationShaddow(),
                        ),
                        SizedBox(height: 20.0),
                        Container(
                          child: TextFormField(
                              controller: eclairageController,
                              decoration: ThemeHelper().textInputDecoration(
                                  'Eclairage Publique',
                                  'Donnez une note pour l\'éclairage publique entre 0 et 5'),
                              keyboardType: TextInputType.number),
                          decoration: ThemeHelper().inputBoxDecorationShaddow(),
                        ),
                        SizedBox(height: 20.0),
                        Container(
                          child: TextFormField(
                              controller: transportController,
                              decoration: ThemeHelper().textInputDecoration(
                                  'Transport',
                                  'Donnez une note pour le transport entre 0 et 5'),
                              keyboardType: TextInputType.number),
                          decoration: ThemeHelper().inputBoxDecorationShaddow(),
                        ),
                        SizedBox(height: 20.0),
                        Container(
                          child: TextFormField(
                              controller: qualiteController,
                              decoration: ThemeHelper().textInputDecoration(
                                  'Qualité route',
                                  'Donnez la qualité de cette route'),
                              keyboardType: TextInputType.text),
                          decoration: ThemeHelper().inputBoxDecorationShaddow(),
                        ),
                        SizedBox(height: 20.0),
                        Container(
                          child: TextFormField(
                              controller: descriptionController,
                              decoration: ThemeHelper().textInputDecoration(
                                  'Description',
                                  'Donnez une description sur l\'emplacement précis et les détails'),
                              keyboardType: TextInputType.text),
                          decoration: ThemeHelper().inputBoxDecorationShaddow(),
                        ),
                        SizedBox(height: 40.0),
                        Container(
                          decoration:
                              ThemeHelper().buttonBoxDecoration(context),
                          child: ElevatedButton(
                            style: ThemeHelper().buttonStyle(),
                            child: Padding(
                              padding:
                                  const EdgeInsets.fromLTRB(40, 10, 40, 10),
                              child: Text(
                                "Soumettre".toUpperCase(),
                                style: TextStyle(
                                  fontSize: 20,
                                  fontWeight: FontWeight.bold,
                                  color: Colors.white,
                                ),
                              ),
                            ),
                            onPressed: () {
                              if (_formKey.currentState!.validate()) {
                                ajouterAvis(
                                    eclairageController.text,
                                    volController.text,
                                    violController.text,
                                    agressionController.text,
                                    transportController.text,
                                    descriptionController.text,
                                    qualiteController.text);
                                final snackBar = SnackBar(
                                  content: Text(_message),
                                  action: SnackBarAction(
                                    label: 'OK',
                                    onPressed: () {
                                      /* Navigator.of(context).pushAndRemoveUntil(
                                          MaterialPageRoute(
                                              builder: (context) =>
                                                  LoginPage()),
                                          (Route<dynamic> route) => false); */
                                    },
                                  ),
                                );
                                ScaffoldMessenger.of(context)
                                    .showSnackBar(snackBar);
                                /* Navigator.of(context).pushAndRemoveUntil(
                                    MaterialPageRoute(
                                        builder: (context) => LoginPage()),
                                    (Route<dynamic> route) => false); */
                                /* Navigator.of(context).pushAndRemoveUntil(
                                    MaterialPageRoute(
                                        builder: (context) => ProfilePage()),
                                    (Route<dynamic> route) => false); */
                              }
                            },
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}
