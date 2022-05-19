import 'package:flutter/material.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:location/location.dart';

class GeolocationFragment extends StatefulWidget {
  State<StatefulWidget> createState() {
    return _GeolocationFragmentState();
  }
}

class _GeolocationFragmentState extends State<GeolocationFragment> {
  CameraPosition _initialPosition = CameraPosition(target: LatLng(0.0, 0.0));
  late GoogleMapController _controller;
  Location _location = Location();
  Set<Marker> markers = {};

  void _onMapCreated(GoogleMapController _ctrl) {
    //GoogleMapController _controller;
    _controller = _ctrl;
    _location.onLocationChanged.listen((dynamic l) {
      _controller.animateCamera(
        CameraUpdate.newCameraPosition(
          CameraPosition(target: LatLng(l.latitude, l.longitude), zoom: 18),
        ),
      );
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        height: MediaQuery.of(context).size.height,
        width: MediaQuery.of(context).size.width,
        child: Stack(
          children: <Widget>[
            GoogleMap(
              initialCameraPosition: _initialPosition,
              mapType: MapType.normal,
              onMapCreated: _onMapCreated,
              myLocationEnabled: true,
              scrollGesturesEnabled: true,
              tiltGesturesEnabled: true,
              rotateGesturesEnabled: true,
              zoomGesturesEnabled: true,
            ),
          ],
        ),
      ),
    );
  }
}
