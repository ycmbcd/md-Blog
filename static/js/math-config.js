MathJax.Hub.Config({
    tex2jax: {
      inlineMath: [ ['$','$'], ["\\(","\\)"] ],
      processEscapes: true  
    },
    TeX: {
      equationNumbers: { autoNumber: "AMS" },
      Macros: {
        mbb: '\\mathbb',
        riff: '\\implies',
        liff: '\\impliedby',
        abs: ['\\left\\lvert #1\\right\\rvert', 1],
        rmd: '\\mathop{}\\!\\mathrm{d}',
        vv: '\\overrightarrow',
        sslash: '\\mathrel{/\\mkern-5mu/}',
        px: '\\mathrel{/\\mkern-5mu/}',
        pqd: '\\stackrel{\\,\\sslash}{\\raise-.5ex{=\\!\\!\\!\\!=}}',
        veps: '\\varepsilon',
        du: '^\\circ',
        bsb: '\\boldsymbol',
        bm: '\\boldsymbol',
        kongji: '\\varnothing',
        buji: '\\complement',
        S: ['S_{\\triangle #1}', 1],
        led: '\\left\\{\\begin{aligned}',
        endled: '\\end{aligned}\\right.',
        edr: '\\left.\\begin{aligned}',
        endedr: '\\end{aligned}\\right\\}',
        an: '\\{a_n\\}',
        bn: '\\{b_n\\}',
        cn: '\\{c_n\\}',
        xn: '\\{x_n\\}',
        Sn: '\\{S_n\\}',
        inR: '\\in\\mbb R',
        inN: '\\in\\mbb N',
        inZ: '\\in\\mbb Z',
        inC: '\\in\\mbb C',
        inQ: '\\in\\mbb Q',
        Rtt: '\\text{Rt}\\triangle',
        LHS: '\\text{LHS}',
        RHS: '\\text{RHS}',
      }
    },
    "HTML-CSS": {
      linebreaks: {automatic: true},
      scale: 85
    },
      menuSettings: {
        zoom: "Double-Click"
    },
    //styles:{
    //'.MathJax':{color:'Blue'},
    //}
  });