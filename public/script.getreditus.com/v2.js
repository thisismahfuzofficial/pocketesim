/*
 * Assumptions:
 *
 * - we do not support multiple pt() trackers on one page.
 *   FIXME (check if GA supports it & figure out how).
 * - Referer and current page URLs are short enough to fit into pixel params.
 *
 * Fixmes:
 *
 * - Beacon support
 */
window.gr = (function (win, doc) {
  "use strict";
  /*
   * Embedding the request ID into the pixel URL allows us to check
   * for missed requests, but makes caching the script impossible, so this
   * should be eventually made optional.
   */
  const REQUEST_ID = "6fb05e12-06b6-45fc-b5b3-8f0ec7aaf4c2";
  const COOKIE_NAME = "_gr_id";
  var customerId;

  function isEmpty(str) {
    return !str || str.length === 0;
  }

  function sanitizedCookieExpiresIn(ce) {
    try {
      var cookieExpiresIn = parseInt(ce);

      if (!cookieExpiresIn || cookieExpiresIn < 1 || cookieExpiresIn > 120) {
        cookieExpiresIn = 60;
      }
      return cookieExpiresIn;
    } catch (e) {
      return 60;
    }
  }

  function cSlugToParams(urlData) {
    if (urlData.via) {
      return {
        cType: "via",
        cSlug: urlData.via,
      };
    } else if (urlData.fpr) {
      return {
        cType: "fpr",
        cSlug: urlData.fpr,
      };
    } else {
      return {};
    }
  }

  /*
   * Object for manipulating cookies
   */
  var cookies = {
    get: function (key) {
      if (!key) {
        return null;
      }

      var encodedKey = encodeURIComponent(key);
      var cs = doc.cookie.split(/\s*;\s*/);
      for (var i = 0; i < cs.length; i++) {
        var c = cs[i].split("=");
        if (c[0] == encodedKey) {
          return decodeURIComponent(c[1]);
        }
      }
      return null;
    },
    set: function (key, value, options) {
      var opts = [];
      if (options) {
        for (var k in options) {
          opts.push([k, options[k]].join("="));
        }
      }
      var cookie =
        [encodeURIComponent(key), encodeURIComponent(value)].join("=") +
        "; " +
        opts.join("; ");
      doc.cookie = cookie;
      return cookie;
    },
  };

  /*
   * Object for manipulating data
   */
  var dataFn = {
    getUrlParam: function () {
      var res = null;
      const params = new URLSearchParams(window.location.search);
      for (var i = 0; i < arguments.length; i += 1) {
        res = params.get(arguments[i]);
        if (res) return removeTrailingSlash(res);
      }
      return ""; // So that it matches cookie parser return
    },
    setReditusCookie: function (urlData, cookieData) {
      const now = new Date().getTime();
      const cookie_ttl = sanitizedCookieExpiresIn(gr.ce) * 24 * 3600 * 1000;
      const expiry = new Date(now + cookie_ttl).toUTCString();
      const cSlugParams = cSlugToParams(urlData);

      var domain;
      if (
        window.location.href.indexOf("localhost") >= 0 ||
        win.location.hostname.split(".").length > 3
      ) {
        domain = win.location.hostname;
      } else {
        // This is required for multi-subdomains
        domain = "." + win.location.hostname.split(".").slice(-2).join(".");
      }
      if (!cookies.get(COOKIE_NAME)) {
        // Set cookie from urlData
        cookies.set(
          COOKIE_NAME,
          [
            urlData.rl,
            urlData.clientId,
            urlData.isTest,
            urlData.pk,
            urlData.uid,
            urlData.wid,
            urlData.affiliateSlug,
            cSlugParams.cSlug,
            cSlugParams.cType,
          ].join(":"),
          { domain: domain, expires: expiry, path: "/" }
        );

        if (!isEmpty(urlData.isDebug)) {
          console.group("REDITUS LOG");
          console.log("Setting Cookie: " + COOKIE_NAME);
          console.groupEnd("REDITUS LOG");
        }
      } else {
        // Set cookie from urlData if pk or isTest changes
        if (
          (urlData.pk && urlData.pk !== cookieData.pk) ||
          (urlData.rl && urlData.rl !== cookieData.rl) ||
          urlData.isTest !== cookieData.isTest ||
          urlData.wid !== cookieData.wid ||
          urlData.affiliateSlug !== cookieData.affiliateSlug ||
          cSlugParams.cSlug !== cookieData.cSlug ||
          cSlugParams.cType !== cookieData.cType
        ) {
          cookies.set(
            COOKIE_NAME,
            [
              urlData.rl,
              urlData.clientId,
              urlData.isTest,
              urlData.pk,
              urlData.uid,
              urlData.wid,
              urlData.affiliateSlug,
              cSlugParams.cSlug,
              cSlugParams.cType,
            ].join(":"),
            { domain: domain, expires: expiry, path: "/" }
          );

          if (!isEmpty(urlData.isDebug)) {
            console.group("REDITUS LOG");
            console.log("Setting Cookie: " + COOKIE_NAME);
            console.groupEnd("REDITUS LOG");
          }
        }
      }
    },
    getUrlData: function () {
      return {
        clientId: uuid(),
        affiliateSlug: this.getUrlParam("red"),
        isTest: this.getUrlParam("gr_tst"),
        pk: this.getUrlParam("gr_pk", "_pk"),
        uid: this.getUrlParam("gr_uid"), // Deprecated field
        wid: this.getUrlParam("gr_wid"),
        rl: this.getUrlParam("rl"),
        isDebug: this.getUrlParam("gr_debug"),
        via: this.getUrlParam("via"),
        fpr: this.getUrlParam("fpr"),
      };
    },
    getCookieData: function () {
      var cookie = cookies.get(COOKIE_NAME);
      if (!cookie) return null;
      var cookieVals = cookie.split(":");
      return {
        rl: cookieVals[0],
        clientId: cookieVals[1],
        isTest: cookieVals[2],
        pk: cookieVals[3],
        uid: cookieVals[4], // Deprecated field
        wid: cookieVals[5],
        affiliateSlug: cookieVals[6],
        cSlug: cookieVals[7],
        cType: cookieVals[8],
      };
    },
  };

  /*
   * Generates a visitor id - a V4 UUID.
   * FIXME: check and use win.crypto if available for better randomness guarantees.
   */
  function uuid() {
    return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(
      /[xy]/g,
      function (c) {
        var r = (Math.random() * 16) | 0,
          v = c == "x" ? r : (r & 0x3) | 0x8;
        return v.toString(16);
      }
    );
  }

  /*
   * Removes trailing slashes
   */
  function removeTrailingSlash(str) {
    return str.replace(/\/+$/, "");
  }

  /*
   * Proxy function that takes arguments in the form of 'function
   * name', 'arg1', ..., 'argn', and dispatches them to the functions defined
   * in fn object.
   */
  function proxy() {
    var args = Array.prototype.slice.call(arguments);
    if (!args || !args[0] || !fn[args[0]]) {
      return;
    }
    fn[args.shift()].apply(fn, args);
  }

  /*
   * These form a 'public' interface/API.
   * calling gr("<function>") in JS console will dispatch through the proxy
   * function to one of these.
   */
  var fn = {
    /* Serializes the tracking arguments into pixel URL params and creates
     * the beacon element.
     *
     * FIXME: the params can be too long to be sent through GET.
     */
    initCustomer: function (id) {
      customerId = id;
    },
    logData: function () {
      console.group("REDITUS LOG");
      console.log("[START] - Call reditus #logData function");
      console.log("Customer ID:");
      console.log(customerId);
      console.log("URL Data:");
      console.log(dataFn.getUrlData());
      console.log("Cookie Data:");
      console.log(dataFn.getCookieData());
      console.log("[END] - Call reditus #logData function");
      console.groupEnd("REDITUS LOG");
    },
    track: function (event, meta) {
      if (!isEmpty(urlData.isDebug)) {
        console.group("REDITUS LOG");
        console.log("[START] - Call reditus #track function");
        console.log("Customer ID:");
        console.log(customerId);
      }

      var d = [];
      var i = doc.createElement("img");
      const cookieData = dataFn.getCookieData();

      if (!isEmpty(urlData.isDebug)) {
        console.log("Customer ID:");
        console.log(customerId);
        console.log("Cookie Data:");
        console.log(cookieData);
      }

      if (!cookieData) return;
      if (!customerId && !cookieData.isTest) return;

      var t = {
        evt: event,
        rid: REQUEST_ID,
        ref: doc.referrer,
        url: win.location,
        grid: cookieData.clientId,
        rl: cookieData.rl,
        pk: cookieData.pk,
        uid: cookieData.uid, // Deprecated field
        wid: cookieData.wid,
        tst: cookieData.isTest,
        affiliate_slug: cookieData.affiliateSlug,
        customer_id: customerId,
        cslug: cookieData.cSlug,
        ctype: cookieData.cType,
      };

      /* Prefix user metadata, so they can be handled separately */
      for (var p in meta) {
        t["m_" + p] = meta[p];
      }
      for (var p in t) {
        d.push(p + "=" + encodeURIComponent(t[p] || ""));
      }

      if (!isEmpty(urlData.isDebug)) {
        console.log("Tracking Data:");
        console.log(t);
      }

      i.src = "https://tr.getreditus.com" + "?" + d.join("&");

      if (!isEmpty(urlData.isDebug)) {
        console.log("[END] - Call reditus #track function");
        console.groupEnd("REDITUS LOG");
      }
    },
  };

  const urlData = dataFn.getUrlData();
  const cookieData = dataFn.getCookieData();

  if (!isEmpty(urlData.isDebug)) {
    console.group("REDITUS LOG");
    console.log("URL Data:");
    console.log(urlData);
    console.log("Cookie Data:");
    console.log(cookieData);
    console.groupEnd("REDITUS LOG");
  }

  if (
    !cookieData &&
    !urlData.isTest &&
    !urlData.pk &&
    !urlData.rl &&
    !urlData.affiliateSlug &&
    !urlData.via &&
    !urlData.fpr
  ) {
    /* Tracking script should not work */
    const dummy = () => {
      console.log("Tracking script not initialized with cookie or URL data.");
    };
    return dummy;
  } else {
    if (
      !cookieData ||
      !isEmpty(urlData.isTest) ||
      !isEmpty(urlData.pk) ||
      !isEmpty(urlData.rl) ||
      !isEmpty(urlData.affiliateSlug) ||
      !isEmpty(urlData.via) ||
      !isEmpty(urlData.fpr)
    ) {
      /* Set the get reditus cookie. */
      dataFn.setReditusCookie(urlData, cookieData);
    }

    /*
     * When loaded asynchronously, the client could have pushed some
     * events into the queue. Run whatever is there.
     */
    while (win.gr.q && win.gr.q.length > 0) {
      proxy.apply(this, win.gr.q.shift());
    }

    /* Replace window.gr with a synchronous function */
    return proxy;
  }
})(window, document);

/* Automatic conversion tracking integrations */

window.addEventListener("message", function (e) {
  const UUID_SEARCH_REGEX =
    /[0-9a-fA-F]{8}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{12}/g;

  if (
    e.origin === "https://calendly.com" &&
    e.data.event &&
    e.data.event === "calendly.event_scheduled"
  ) {
    var [cal_event, cal_user] =
      e.data.payload.invitee.uri.match(UUID_SEARCH_REGEX);
    console.log("Calendly event scheduled: " + cal_event + " by " + cal_user);
    gr("track", "conversion", {
      source: "calendly",
      cal_event: cal_event,
      cal_user: cal_user,
    });
  }
});

window.addEventListener("message", function (e) {
  if (
    /* Hubspot, iframe embeds */
    (e.data.type === "hsFormCallback" &&
      e.data.eventName === "onFormSubmitted") ||
    /* Hubspot, popups */
    (e.origin.endsWith(".hubspot.com") &&
      e.data.formGuid !== null &&
      e.data.accepted == true) ||
    /* Hubspot Calendar book event */
    (e.data.meetingBookSucceeded === true &&
      e.data.meetingsPayload &&
      e.data.meetingsPayload.bookingResponse &&
      e.data.meetingsPayload.bookingResponse.postResponse &&
      e.data.meetingsPayload.bookingResponse.postResponse.contact)
  ) {
    var hubspotutk = null;
    var email = null;
    var cs = document.cookie.split(/\s*;\s*/);

    for (var i = 0; i < cs.length; i++) {
      var c = cs[i].split("=");
      if (c[0] == "hubspotutk") {
        hubspotutk = decodeURIComponent(c[1]);
        break;
      }
    }

    console.log("Found Hubspot utk: " + hubspotutk);

    // Is Calendar
    if (e.data.meetingBookSucceeded === true) {
      email = e.data.meetingsPayload.bookingResponse.postResponse.contact.email;
    }

    if (
      e.data.type === "hsFormCallback" &&
      e.data.eventName === "onFormSubmitted"
    ) {
      email = e.data.data.submissionValues.email;
    }

    console.log("Hubspot tracking");

    if (hubspotutk !== null) {
      console.log("Hubspot form submitted: " + hubspotutk);
      gr("track", "conversion", {
        source: "hubspot",
        hub_utk: hubspotutk,
        email: email,
      });
    }
  }
});
